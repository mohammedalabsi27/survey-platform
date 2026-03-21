<?php

namespace App\Livewire\Surveys;

use Livewire\Component;
use Livewire\Attributes\On; // 👈 استدعاء الميزة
use App\Models\Survey;

class SurveyBuilder extends Component
{
    public $survey;
    public $activeTab = 'questions';
    
    public function mount($survey)
    {
        $this->survey = $survey;
    }
    
    // 👇 استبدلنا مصفوفة $listeners القديمة بهذه الطريقة النظيفة
    #[On('questionAdded')]
    public function handleQuestionAdded($questionId)
    {
        $this->survey->refresh();
        session()->flash('success', 'تم إضافة السؤال بنجاح!');
    }
    
    #[On('questionUpdated')]
    public function handleQuestionUpdated()
    {
        session()->flash('success', 'تم تحديث السؤال بنجاح!');
    }
    
    #[On('questionDeleted')]
    public function handleQuestionDeleted()
    {
        session()->flash('success', 'تم حذف السؤال بنجاح!');
    }
    
    #[On('optionUpdated')]
    public function handleOptionUpdated()
    {
        session()->flash('success', 'تم تحديث الخيارات بنجاح!');
    }
    
    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }

    // 💡 دالة تغيير حالة الاستبيان (نشر / إيقاف)
    public function toggleStatus()
    {
        // عكس الحالة
        $newStatus = $this->survey->status === 'published' ? 'draft' : 'published';
        
        // حفظ في قاعدة البيانات
        $this->survey->update(['status' => $newStatus]);
        
        // رسالة تظهر للمستخدم
        $message = $newStatus === 'published' 
            ? 'تم نشر الاستبيان بنجاح! يمكن للجمهور الآن المشاركة.' 
            : 'تم إيقاف الاستبيان وإعادته كمسودة.';
            
        session()->flash('success', $message);
    }
    
    public function render()
    {
        return view('surveys.survey-builder');
    }
}