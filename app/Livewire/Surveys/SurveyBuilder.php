<?php

namespace App\Livewire\Surveys;

use Livewire\Component;
use App\Models\Survey;

class SurveyBuilder extends Component
{
    public $survey;
    public $activeTab = 'questions';
    
    
    protected $listeners = [
        'questionAdded' => 'handleQuestionAdded',
        'questionUpdated' => 'handleQuestionUpdated',
        'questionDeleted' => 'handleQuestionDeleted',
        'optionUpdated' => 'handleOptionUpdated'
    ];
    
    public function mount($survey)
    {
        $this->survey = $survey;
    }
    

    
    public function handleQuestionAdded($questionId)
    {
        $this->survey->refresh();
        session()->flash('success', 'تم إضافة السؤال بنجاح!');
    }
    
    public function handleQuestionUpdated()
    {
        session()->flash('success', 'تم تحديث السؤال بنجاح!');
    }
    
    public function handleQuestionDeleted()
    {
        session()->flash('success', 'تم حذف السؤال بنجاح!');
    }
    
    public function handleOptionUpdated()
    {
        session()->flash('success', 'تم تحديث الخيارات بنجاح!');
    }
    
    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }
    
    public function render()
    {
        return view('surveys.survey-builder');
    }
}
