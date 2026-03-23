<?php

namespace App\Livewire\Surveys\Builder;

use Livewire\Attributes\Validate;
use Livewire\Component;

class SurveySettings extends Component
{
    public $survey;

    #[Validate('required|string|max:255', message: 'عنوان الاستبيان مطلوب')]
    public $title;

    #[Validate('nullable|string|max:1000')]
    public $description;

    #[Validate('nullable|date')]
    public $start_date;

    #[Validate('nullable|date|after_or_equal:start_date', message: 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية')]
    public $end_date;

    #[Validate('required|string')]
    public $theme_color;

    #[Validate('nullable|string|max:1000')]
    public $thank_you_message;

    public function mount($survey)
    {
        $this->survey = $survey;
        $this->title = $survey->title;
        $this->description = $survey->description;
        $this->theme_color = $survey->theme_color ?? 'blue';
        $this->thank_you_message = $survey->thank_you_message;
        
        // تحويل التواريخ لصيغة يفهمها حقل HTML datetime-local
        $this->start_date = $survey->start_date ? \Carbon\Carbon::parse($survey->start_date)->format('Y-m-d\TH:i') : null;
        $this->end_date = $survey->end_date ? \Carbon\Carbon::parse($survey->end_date)->format('Y-m-d\TH:i') : null;
    }

    public function saveSettings()
    {
        $this->validate();

        $this->survey->update([
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
            'theme_color' => $this->theme_color,
            'thank_you_message' => $this->thank_you_message,
        ]);
        // $this->dispatch('surveyUpdated'); // إظهار رسالة "تم الحفظ"
        session()->flash('success', 'تم حفظ إعدادات الاستبيان بنجاح!');
    }

    public function render()
    {
        return view('surveys.builder.survey-settings');
    }
}
