<?php

namespace App\Livewire\Surveys;

use Livewire\Component;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

class SurveysList extends Component
{
    public $search = '';

    protected $listeners = ['surveyCreated' => '$refresh'];

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
