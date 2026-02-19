<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LogoutComponent extends Component
{
    public function logout()
    {
        Auth::guard('web')->logout();

        session()->forget('guard.web');

        session()->regenerateToken();

        return to_route('login');

    }

    public function render()
    {
        return view('auth.logout-component');
    }
}
