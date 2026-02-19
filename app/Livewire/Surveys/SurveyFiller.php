<?php

namespace App\Livewire\Surveys;

use Livewire\Component;
use App\Models\Survey;
use App\Models\Response;
use App\Models\Answer;

class SurveyFiller extends Component
{
    public $survey;
    public $answers = [];
    public $isSubmitted = false;

    public function mount($survey)
    {
        $this->survey = $survey;
        
        // نجهز مصفوفة الإجابات الفارغة
        foreach ($this->survey->questions as $question) {
            $this->answers[$question->id] = $this->getDefaultAnswer($question->type);
        }
    }

    // نحدد القيمة الافتراضية حسب نوع السؤال
    private function getDefaultAnswer($type)
    {
        return match($type) {
            'text', 'textarea' => '',
            'choice', 'yes_no' => null,
            'multiple_choice' => [],
            'rating' => 0,
            default => ''
        };
    }

    // دالة إرسال الاستبيان
    public function submitSurvey()
    {
        // نتحقق من الإجابات المطلوبة
        foreach ($this->survey->questions as $question) {
            if ($question->required) {
                $answer = $this->answers[$question->id] ?? '';
                
                if (empty($answer) || (is_array($answer) && empty($answer))) {
                    session()->flash('error', 'يرجى الإجابة على جميع الأسئلة المطلوبة');
                    return;
                }
            }
        }
        // dd($this->answers);
        // نحفظ الرد في قاعدة البيانات
        $response = Response::create([
            'survey_id' => $this->survey->id,
            'responder_ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // نحفظ كل الإجابات
        foreach ($this->answers as $questionId => $answerValue) {
            if (!empty($answerValue) && !(is_array($answerValue) && empty($answerValue))) {
                Answer::create([
                    'response_id' => $response->id,
                    'question_id' => $questionId,
                    'answer_text' => is_array($answerValue) ? json_encode($answerValue) : $answerValue
                ]);
            }
        }

        $this->isSubmitted = true;
        session()->flash('success', 'شكراً لك! تم إرسال إجاباتك بنجاح 🎉');
    }

    public function getQuestionTypeArabic($type)
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

    // ونضيف دالة لحساب الأسئلة المكتملة
    public function getCompletedQuestionsCount()
    {
        $count = 0;
        foreach ($this->answers as $answer) {
            if (!empty($answer) && !(is_array($answer) && empty($answer))) {
                $count++;
            }
        }
        return $count;
    }

    public function render()
    {
        return view('surveys.survey-filler');
    }
}
