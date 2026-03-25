<?php

namespace App\Livewire\Layouts;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationBell extends Component
{
     protected $listeners =['echo:notifications,NotificationEvent' => '$refresh'];

    public function getUnreadNotificationsProperty()
    {
        return Auth::check() ? Auth::user()->unreadNotifications : collect();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }
    
    public function render()
    {
        return view('layouts.notification-bell');
    }
}
