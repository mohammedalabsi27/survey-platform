<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginComponent extends Component
{
    public $email;
    public $password;
    public $remember;
    
    protected $rules= [
        'email' => 'required|email',
        'password' => 'required',
    ];


    public function login()
    {
        $this->validate();
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            return redirect()->route('dashboard');
        } else {
        $this->addError('email', 'بيانات الدخول غير صحيحة');
    }
    }

    public function render()
    {
        return view('auth.login-component');
    }
}
