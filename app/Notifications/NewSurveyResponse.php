<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSurveyResponse extends Notification
{
    use Queueable;

    public $survey;
    public $responseId;

    public function __construct($survey, $responseId)
    {
        $this->survey = $survey;
        $this->responseId = $responseId;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return[
            'survey_id' => $this->survey->id,
            'survey_slug' => $this->survey->slug ?? $this->survey->id,
            'survey_title' => $this->survey->title,
            'message' => 'رد جديد على استبيان: ' . $this->survey->title,
            'icon' => 'fas fa-bolt',
            'color' => 'green'
        ];
    }
}
