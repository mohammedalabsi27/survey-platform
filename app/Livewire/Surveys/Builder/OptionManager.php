<?php

namespace App\Livewire\Surveys\Builder;

use Livewire\Component;
use Livewire\Attributes\On; // 👈 استدعاء الميزة
use App\Models\Question;
use App\Models\Option;

class OptionManager extends Component
{
    public $question;
    public $options =[];
    
    public function mount($question)
    {
        $this->question = $question;
        $this->loadOptions();
    }
    
    // 👇 تحديث الحدث
    #[On('refreshOptions')]
    public function loadOptions()
    {
        $this->options = $this->question->options()->get();
    }
    
    public function addOption()
    {
        if (!in_array($this->question->type, ['choice', 'multiple_choice'])) {
            return;
        }
        
        Option::create([
            'question_id' => $this->question->id,
            'option_text' => 'خيار جديد',
        ]);
        
        $this->loadOptions();
        $this->dispatch('optionUpdated'); // 👈 إرسال الحدث بالطريقة الجديدة
    }
    
    public function removeOption($optionId)
    {
        $option = Option::find($optionId);
        if ($option) {
            $option->delete();
            $this->dispatch('optionUpdated');
            $this->loadOptions(); // تحديث القائمة بعد الحذف
        }
    }
    
    public function updateOption($optionId, $newText)
    {
        $option = Option::find($optionId);
        if ($option && trim($newText) !== '') {
            $option->update(['option_text' => $newText]);
            $this->dispatch('optionUpdated');
        }
    }
    
    public function render()
    {
        return view('surveys.builder.option-manager');
    }
}