<?php

namespace App\Livewire\Surveys\Builder;

use Livewire\Component;
use App\Models\Survey;
use App\Traits\QuestionTypes;

class QuestionSidebar extends Component
{
    use QuestionTypes;
    
    public $survey;
    
    public function mount($survey)
    {
        $this->survey = $survey;
    }
    
    public function addQuestion($type)
    {
        // التحقق من صحة نوع السؤال
        $validTypes = ['text', 'textarea', 'choice', 'multiple_choice', 'yes_no', 'rating'];
        
        if (!in_array($type, $validTypes)) {
            session()->flash('error', 'نوع السؤال غير صحيح');
            return;
        }
        
        try {
            // إنشاء السؤال
            $question = $this->survey->questions()->create([
                'question_text' => $this->getDefaultQuestionText($type),
                'type' => $type,
                'order' => $this->survey->questions()->count() + 1
            ]);
            
            // إرسال حدث للمكون الرئيسي
            $this->dispatch('questionAdded', questionId: $question->id);
            
            // رسالة نجاح
            session()->flash('sidebar-success', 'تم إضافة سؤال ' . $this->getTypeArabic($type));
            
        } catch (\Exception $e) {
            session()->flash('error', 'حدث خطأ أثناء إضافة السؤال: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('surveys.builder.question-sidebar');
    }
}
