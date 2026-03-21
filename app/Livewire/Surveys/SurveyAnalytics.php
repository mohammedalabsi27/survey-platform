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

    //  دالة لتحليل إجابات الأسئلة الاختيارية والاختيار المتعدد
    public function getChoiceStats($question)
    {
        if (!in_array($question->type, ['choice', 'multiple_choice'])) {
            return null;
        }
        
        $stats = [];
        $totalResponses = $this->survey->responses()->count();
        
        foreach ($question->options as $option) {
            // نستخدم الايجابات المحملة مسبقاً (eager loaded) لعدم عمل استعلامات N+1
            $count = $question->answers->filter(function($ans) use ($option, $question) {
                // النظام الجديد باستخدام option_id
                if ($ans->option_id == $option->id) {
                    return true;
                }
                
                // النظام القديم (للتوافق مع البيانات السابقة إن وجدت)
                if (!$ans->option_id) {
                    if ($question->type == 'multiple_choice') {
                        $decoded = json_decode($ans->answer_text, true);
                        return is_array($decoded) && in_array($option->option_text, $decoded);
                    }
                    if ($question->type == 'choice') {
                        return $ans->answer_text === $option->option_text;
                    }
                }
                
                return false;
            })->count();
            
            $percentage = $totalResponses > 0 ? round(($count / $totalResponses) * 100, 1) : 0;
            
            $stats[] = [
                'option' => $option->option_text,
                'count' => $count,
                'percentage' => $percentage
            ];
        }
        
        return $stats;
    }

    //  دالة خاصة لتحليل الـ multiple_choice تستخدم نفس المنطق الموحد
    public function getMultipleChoiceStats($question)
    {
        return $this->getChoiceStats($question);
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

    // 💡 دالة تصدير الردود إلى ملف Excel (CSV)
    public function exportResponses()
    {
        $fileName = 'نتائج_استبيان_' . $this->survey->id . '_' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $file = fopen('php://output', 'w');
            
            // إضافة BOM لدعم اللغة العربية في Excel بدون ظهور رموز غريبة
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // تجهيز عناوين الأعمدة (رقم المشاركة، التاريخ، ثم نصوص الأسئلة)
            $columns = ['رقم المشاركة', 'تاريخ المشاركة'];
            foreach ($this->survey->questions as $question) {
                $columns[] = $question->question_text;
            }
            fputcsv($file, $columns);

            // جلب الردود وكتابة الإجابات صفا بصف
            foreach ($this->survey->responses as $response) {
                $row =[
                    $response->id,
                    $response->created_at->format('Y-m-d H:i A')
                ];

                foreach ($this->survey->questions as $question) {
                    // جلب كل الإجابات لهذا السؤال (لأن الاختيار المتعدد يحفظ كعدة صفوف)
                    $answers = $response->answers->where('question_id', $question->id);
                    
                    if ($answers->count() > 0) {
                        $answerTexts =[];
                        foreach ($answers as $ans) {
                            if ($ans->option_id) {
                                // إذا كان خياراً (يحتوي على option_id)، نجلب نص الخيار
                                $answerTexts[] = $ans->option->option_text ?? '';
                            } else {
                                // إذا كان نصاً 
                                $answerTexts[] = $ans->answer_text;
                            }
                        }
                        // دمج الإجابات (إذا كانت اختيار متعدد) بفاصلة
                        $row[] = implode(' ، ', array_filter($answerTexts));
                    } else {
                        // إذا لم يقم المستخدم بالإجابة على هذا السؤال
                        $row[] = 'لم يُجب'; 
                    }
                }
                // كتابة الصف في ملف الـ CSV
                fputcsv($file, $row);
            }
            fclose($file);
        }, $fileName,[
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }


    public function render()
    {
        return view('surveys.survey-analytics');
    }
}
