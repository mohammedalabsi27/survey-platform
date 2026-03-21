<?php

namespace App\Livewire\Surveys\Builder;

use Livewire\Component;
use Livewire\Attributes\On; 
use App\Models\Survey;
use App\Traits\QuestionTypes;

class QuestionList extends Component
{
    use QuestionTypes;
    
    public $survey;
    public $questions;
    
    public function mount($survey)
    {
        $this->survey = $survey;
        $this->loadQuestions();
    }
    
    public function loadQuestions()
    {
        $this->questions = $this->survey->questions()
            ->with('options')
            ->orderBy('order')
            ->get();
    }
    
    #[On('questionAdded')]
    public function refreshQuestions()
    {
        $this->loadQuestions();
    }

    // 💡 هذه هي الدالة الجديدة للحفظ التلقائي
    public function updateQuestionText($questionId, $newText)
    {
        $question = $this->survey->questions()->find($questionId);
        
        // نتحقق أن السؤال موجود وأن النص الجديد ليس فارغاً
        if ($question && trim($newText) !== '') {
            $question->update(['question_text' => $newText]);
            $this->dispatch('questionUpdated'); // إظهار رسالة "تم الحفظ"
            $this->loadQuestions(); // تحديث القائمة
        }
    }

    // 💡 دالة تفعيل/إلغاء إلزامية السؤال
    public function toggleRequired($questionId)
    {
        $question = $this->survey->questions()->find($questionId);
        
        if ($question) {
            // عكس الحالة الحالية (True إلى False والعكس)
            $question->update(['required' => !$question->required]);
            
            // تحديث الواجهة
            $this->loadQuestions();
            
            // إظهار رسالة نجاح صغيرة
            $status = $question->required ? 'إجباري' : 'اختياري';
            session()->flash('success', "تم جعل السؤال: {$status}");
        }
    }
    
    public function deleteQuestion($questionId)
    {
        $question = $this->survey->questions()->find($questionId);
        if ($question) {            
            $question->delete();
            $this->reorderQuestions();
            $this->loadQuestions();
            $this->dispatch('questionDeleted');
        }
    }
    
    private function reorderQuestions()
    {
        $questions = $this->survey->questions()->orderBy('order')->get();
        foreach ($questions as $index => $question) {
            $question->update(['order' => $index + 1]);
        }
    }
    
    // 💡 دالة ترتيب الأسئلة (السحب والإفلات)
    public function updateQuestionOrder($orderedIds)
    {
        // $orderedIds هي مصفوفة تحتوي على أرقام الأسئلة بالترتيب الجديد
        foreach ($orderedIds as $index => $id) {
            $this->survey->questions()->where('id', $id)->update(['order' => $index + 1]);
        }
        
        $this->loadQuestions(); // تحديث القائمة لإظهار الأرقام الجديدة
        
        // إظهار رسالة نجاح صغيرة
        session()->flash('success', 'تم حفظ ترتيب الأسئلة الجديد بنجاح!');
    }

    public function render()
    {
        return view('surveys.builder.questions-list');
    }
}