@extends('auth.master')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">تسجيل الدخول</h2>
    @livewire('auth.login-component')
</div>
@endsection
