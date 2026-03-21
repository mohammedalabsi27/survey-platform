<?php

namespace App\Livewire\Surveys;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

class SurveysCreate extends Component
{
    public $showModal = false;

    // التعديل هنا: نقلنا قواعد التحقق لتكون فوق المتغيرات مباشرة
    #[Validate('required|string|max:255', message: 'يرجى إدخال عنوان للاستبيان')]
    public $title;

    #[Validate('nullable|string|max:1000')]
    public $description;

    #[On('openCreateModal')]
    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['title', 'description']);
        $this->resetValidation(); 
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