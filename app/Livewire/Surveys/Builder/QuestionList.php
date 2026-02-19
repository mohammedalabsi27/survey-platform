<?php

namespace App\Livewire\Surveys\Builder;

use Livewire\Component;
use App\Models\Survey;
use App\Traits\QuestionTypes;

class QuestionList extends Component
{
    use QuestionTypes;
    
    public $survey;
    public $editingQuestionId = null;
    public $editedText = '';
    
    public $questions;
    
    protected $listeners = [
        'questionAdded' => 'refreshQuestions',
    ];
    
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
    
    public function refreshQuestions()
    {
        $this->loadQuestions();
        $this->cancelEditing();     
    }

    public function startEditing($questionId)
    {
        $question = $this->survey->questions()->find($questionId);
        if ($question) {
            $this->editingQuestionId = $questionId;
            $this->editedText = $question->question_text;
        }
    }
    
    public function saveEditing()
    {
        if ($this->editingQuestionId && trim($this->editedText) !== '') {
            $question = $this->survey->questions()->find($this->editingQuestionId);

            if ($question) {
                $question->update(['question_text' => $this->editedText]);

                $this->dispatch('questionUpdated');
            }
            
            $this->refreshQuestions();
        }
    }

    public function cancelEditing()
    {
        $this->editingQuestionId = null;
        $this->editedText = '';
    }

    
    public function deleteQuestion($questionId)
    {
        $question = $this->survey->questions()->find($questionId);
        
        if ($question) {            
            $question->delete();
            
            // إعادة ترتيب الأسئلة المتبقية
            $this->reorderQuestions();

            $this->loadQuestions();

            if ($this->editingQuestionId == $questionId) {
                $this->cancelEditing();
            }

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
    
    public function render()
    {
        return view('surveys.builder.questions-list');
    }
}