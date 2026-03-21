<?php

namespace App\Livewire\Surveys;

use App\Models\Answer;
use App\Models\Response;
use App\Models\Survey;
use App\Traits\QuestionTypes;
use Livewire\Component;

class SurveyFiller extends Component
{
    use QuestionTypes;

    public $survey;
    public $answers = [];
    public $isSubmitted = false;
    public $isClosed = false; //  متغير جديد لمعرفة هل الاستبيان مغلق؟


    public function mount($survey)
    {
        $this->survey = $survey;
        
        // التحقق من حالة الاستبيان قبل كل شيء
        if ($this->survey->status !== 'published') {
            $this->isClosed = true;
            return; // نوقف تنفيذ باقي الكود ولا نحمل الأسئلة
        }

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
        if ($this->survey->status !== 'published') {
            session()->flash('error', 'عذراً، هذا الاستبيان مغلق حالياً ولا يستقبل ردوداً.');
            return;
        }
        // بناء قواعد التحقق ديناميكياً
        $rules = [];
        $messages = [];
        
        foreach ($this->survey->questions as $question) {
            if ($question->required) {
                if ($question->type == 'multiple_choice') {
                    $rules["answers.{$question->id}"] = 'required|array|min:1';
                } else {
                    $rules["answers.{$question->id}"] = 'required';
                }
                $messages["answers.{$question->id}.required"] = 'هذا السؤال مطلوب للإجابة عليه.';
            }
        }

        if (!empty($rules)) {
            $this->validate($rules, $messages);
        }
        // نحفظ الرد في قاعدة البيانات
        $response = Response::create([
            'survey_id' => $this->survey->id,
            'responder_ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // نحفظ كل الإجابات
        foreach ($this->answers as $questionId => $answerValue) {
            if (!empty($answerValue) && !(is_array($answerValue) && empty($answerValue))) {
                $question = $this->survey->questions->find($questionId);
                
                if (is_array($answerValue) && $question->type == 'multiple_choice') {
                    foreach ($answerValue as $ansItem) {
                        $option = $question->options->where('option_text', $ansItem)->first();
                        Answer::create([
                            'response_id' => $response->id,
                            'question_id' => $questionId,
                            'answer_text' => $ansItem,
                            'option_id' => $option ? $option->id : null
                        ]);
                    }
                } else {
                    $optionId = null;
                    if ($question->type == 'choice') {
                        $option = $question->options->where('option_text', $answerValue)->first();
                        $optionId = $option ? $option->id : null;
                    }

                    Answer::create([
                        'response_id' => $response->id,
                        'question_id' => $questionId,
                        'answer_text' => $answerValue,
                        'option_id' => $optionId
                    ]);
                }
            }
        }

        $this->isSubmitted = true;
        session()->flash('success', 'شكراً لك! تم إرسال إجاباتك بنجاح 🎉');
    }

    // public function getQuestionTypeArabic($type)
    // {
    //     $types = [
    //         'text' => 'نص قصير',
    //         'textarea' => 'نص طويل',
    //         'choice' => 'اختيار وحيد',
    //         'multiple_choice' => 'اختيار متعدد',
    //         'yes_no' => 'نعم/لا',
    //         'rating' => 'تقييم'
    //     ];
        
    //     return $types[$type] ?? $type;
    // }

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
