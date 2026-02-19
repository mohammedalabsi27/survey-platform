<?php

namespace App\Livewire\Surveys;

use Livewire\Component;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

class SurveysCreate extends Component
{
    public $showModal = false;
    public $title;
    public $description;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ];
    
    protected $listeners = ['openCreateModal' => 'openModal'];

    public function openModal()
    {
        $this->showModal = true;
    }

  
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['title', 'description']); // نظف الحقول
    }

    public function save()
    {
        $this->validate();

        Survey::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'status' => 'draft',
        ]);

        $this->closeModal();
        $this->dispatch('surveyCreated'); 
        session()->flash('success', 'تم إنشاء الاستبيان بنجاح');
    }

    public function render()
    {
        return view('surveys.surveys-create');
    }
}
