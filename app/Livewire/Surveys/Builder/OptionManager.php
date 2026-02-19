<?php

namespace App\Livewire\Surveys\Builder;

use Livewire\Component;
use App\Models\Question;
use App\Models\Option;

class OptionManager extends Component
{
    public $question;
    public $options = [];
    
    protected $listeners = ['refreshOptions' => 'loadOptions'];
    
    public function mount($question)
    {
        $this->question = $question;
        $this->loadOptions();
    }
    
    public function loadOptions()
    {
        $this->options = $this->question->options()
            // ->orderBy('order')
            ->get();
    }
    
    public function addOption()
    {
        if (!in_array($this->question->type, ['choice', 'multiple_choice'])) {
            return;
        }
        
        // $order = $this->options->count() + 1;
        
        Option::create([
            'question_id' => $this->question->id,
            'option_text' => 'خيار جديد',
            // 'order' => $order
        ]);
        
        $this->loadOptions();
        $this->dispatch('optionUpdated')->to(\App\Livewire\Surveys\SurveyBuilder::class);
    }
    
    public function removeOption($optionId)
    {
        $option = Option::find($optionId);
        if ($option) {
            $option->delete();
            // $this->reorderOptions();
            $this->dispatch('optionUpdated')->to(\App\Livewire\Surveys\SurveyBuilder::class);
        }
    }
    
    public function updateOption($optionId, $newText)
    {
        $option = Option::find($optionId);
        if ($option && trim($newText) !== '') {
            $option->update(['option_text' => $newText]);
            $this->dispatch('optionUpdated')->to(\App\Livewire\Surveys\SurveyBuilder::class);
        }
    }
    
    // private function reorderOptions()
    // {
    //     $options = $this->question->options()->orderBy('order')->get();
    //     foreach ($options as $index => $option) {
    //         $option->update(['order' => $index + 1]);
    //     }
    //     $this->loadOptions();
    // }
    
    public function render()
    {
        return view('surveys.builder.option-manager');
    }
}
