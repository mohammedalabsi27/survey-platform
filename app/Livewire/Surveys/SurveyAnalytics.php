<?php

namespace App\Livewire\Surveys;

use Livewire\Component;
use App\Models\Survey;
use App\Models\Answer;

class SurveyAnalytics extends Component
{
    public $survey;
    public $stats;

    public function mount($survey)
    {
        $this->survey = $survey->load([
            'questions.options', 
            'questions.answers',
            'responses.answers'
        ]);
        $this->loadStats();
    }

    public function loadStats()
    {
        $totalResponses = $this->survey->responses()->count();
        $totalQuestions = $this->survey->questions()->count();
        
        $this->stats = [
            'total_responses' => $totalResponses,
            'total_questions' => $totalQuestions,
            'completion_rate' => $totalResponses > 0 ? '100%' : '0%',
            'avg_time' => '5 دقائق', // افتراضي حالياً
        ];
    }

    //  دالة لتحليل إجابات الأسئلة الاختيارية (للـ choice فقط)
    public function getChoiceStats($question)
    {
        if ($question->type != 'choice') {
            return null;
        }
        
        $stats = [];
        $totalResponses = $this->survey->responses()->count();
        
        foreach ($question->options as $option) {
            // عد الإجابات لسؤال اختيار وحيد فقط
            $count = Answer::where('question_id', $question->id)
                        ->where('answer_text', $option->option_text)
                        ->count();
            
            $percentage = $totalResponses > 0 ? round(($count / $totalResponses) * 100, 1) : 0;
            
            $stats[] = [
                'option' => $option->option_text,
                'count' => $count,
                'percentage' => $percentage
            ];
        }
        
        return $stats;
    }

    //  دالة خاصة لتحليل الـ multiple_choice
    public function getMultipleChoiceStats($question)
    {
        if ($question->type != 'multiple_choice') {
            return null;
        }
        
        $stats = [];
        $totalResponses = $this->survey->responses()->count();
        
        // نجمع كل الإجابات لهذا السؤال
        $answers = Answer::where('question_id', $question->id)->get();
        
        foreach ($question->options as $option) {
            $count = 0;
            
            foreach ($answers as $answer) {
                // نحاول نقرأ الإجابة كـ JSON
                $answerData = json_decode($answer->answer_text, true);
                
                if (is_array($answerData)) {
                    // إذا كانت مصفوفة، نتحقق إذا الخيار موجود
                    if (in_array($option->option_text, $answerData)) {
                        $count++;
                    }
                } else {
                    // إذا كانت نص عادي، نتحقق إذا الخيار موجود في النص
                    if (str_contains($answer->answer_text, $option->option_text)) {
                        $count++;
                    }
                }
            }
            
            $percentage = $totalResponses > 0 ? round(($count / $totalResponses) * 100, 1) : 0;
            
            $stats[] = [
                'option' => $option->option_text,
                'count' => $count,
                'percentage' => $percentage
            ];
        }
        
        return $stats;
    }
        // دالة لتحليل سؤال نعم/لا
    public function getYesNoStats($question)
    {
        if ($question->type != 'yes_no') {
            return null;
        }
        
        $totalResponses = $this->survey->responses()->count();
        
        $yesCount = Answer::where('question_id', $question->id)
                        ->where('answer_text', 'نعم')
                        ->count();
        
        $noCount = Answer::where('question_id', $question->id)
                        ->where('answer_text', 'لا')
                        ->count();
        
        $totalVotes = $yesCount + $noCount;
        
        return [
            'نعم' => [
                'count' => $yesCount,
                'percentage' => $totalVotes > 0 ? round(($yesCount / $totalVotes) * 100, 1) : 0,
                'total_responses' => $totalResponses
            ],
            'لا' => [
                'count' => $noCount,
                'percentage' => $totalVotes > 0 ? round(($noCount / $totalVotes) * 100, 1) : 0,
                'total_responses' => $totalResponses
            ]
        ];
    }

    // دالة لتحليل سؤال التقييم
    public function getRatingStats($question)
    {
        if ($question->type != 'rating') {
            return null;
        }
        
        $totalResponses = $this->survey->responses()->count();
        $ratings = [];
        $totalVotes = 0;
        
        for ($i = 1; $i <= 5; $i++) {
            $count = Answer::where('question_id', $question->id)
                        ->where('answer_text', (string)$i)
                        ->count();
            
            $ratings[$i] = [
                'count' => $count,
                'percentage' => $totalResponses > 0 ? round(($count / $totalResponses) * 100, 1) : 0
            ];
            
            $totalVotes += $count;
        }
        
        return [
            'ratings' => $ratings,
            'average' => $totalVotes > 0 ? round(array_sum(array_map(function($i) use ($ratings) {
                return $i * $ratings[$i]['count'];
            }, range(1, 5))) / $totalVotes, 1) : 0,
            'total_votes' => $totalVotes
        ];
    }

    // دالة لتحليل الأسئلة النصية
    public function getTextAnswers($question)
    {
        if (!in_array($question->type, ['text', 'textarea'])) {
            return null;
        }
        
        return Answer::where('question_id', $question->id)
                    ->whereNotNull('answer_text')
                    ->where('answer_text', '!=', '')
                    ->get()
                    ->take(10); // نعرض أول 10 إجابات فقط
    }

    public function getQuestionTypeText($type)
    {
        $types = [
            'text' => 'نص قصير',
            'textarea' => 'نص طويل',
            'choice' => 'اختيار وحيد',
            'multiple_choice' => 'اختيار متعدد',
            'yes_no' => 'نعم/لا',
            'rating' => 'تقييم'
        ];
        
        return $types[$type] ?? $type;
    }


    public function render()
    {
        return view('surveys.survey-analytics');
    }
}
