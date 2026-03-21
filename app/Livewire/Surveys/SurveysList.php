<?php

namespace App\Livewire\Surveys;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; 
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

class SurveysList extends Component
{
    use WithPagination;

    public $search = '';

    // التعديل هنا: استخدمنا #[On] بدلاً من $listeners
    #[On('surveyCreated')] 
    public function refreshList()
    {
        $this->resetPage(); 
    }

    public function render()
    {
        $surveys = Survey::where('user_id', Auth::id())
            ->where('title',  'like', '%'.$this->search.'%')
            ->withCount(['questions', 'responses'])
            ->latest()
            ->paginate(10); 

        return view('surveys.surveys-list', compact('surveys'));
    }
}