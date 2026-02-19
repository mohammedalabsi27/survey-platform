@extends('master')

@section('title', 'تصميم الاستبيان')
@section('header', 'مصمم الاستبيانات')

@section('content')
    <div class="fade-in">    
        <livewire:surveys.survey-builder :survey="$survey" />
    </div>
@endsection