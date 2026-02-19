@extends('auth.master')

@section('title', 'تسجيل حساب جديد')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">تسجيل حساب جديد</h2>
    @livewire('auth.register-component')
</div>
@endsection
