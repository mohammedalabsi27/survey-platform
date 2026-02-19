@extends('master')

@section('title', 'لوحة التحكم')
@section('header', 'لوحة التحكم')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

    {{-- البطاقة الأولى: عدد الاستبيانات --}}
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition flex items-center justify-between">
        <div class="text-right">
            <h3 class="text-gray-500 font-medium">الاستبيانات</h3>
            <p class="text-3xl font-bold text-gray-900">{{-- $surveys->count() ?? 0 --}}</p>
        </div>
        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 3h18v18H3V3z"/>
        </svg>
    </div>

    {{-- البطاقة الثانية: عدد الردود --}}
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition flex items-center justify-between">
        <div class="text-right">
            <h3 class="text-gray-500 font-medium">الردود</h3>
            <p class="text-3xl font-bold text-gray-900">{{-- $responses->count() ?? 0 --}}</p>
        </div>
        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 4v16m8-8H4"/>
        </svg>
    </div>

    {{-- البطاقة الثالثة: إنشاء استبيان جديد --}}
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition flex flex-col items-center justify-center text-center">
        <h3 class="text-gray-500 font-medium mb-2">إنشاء استبيان جديد</h3>
        <button wire:click="$toggle('showSurveyBuilder')" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            إنشاء الآن
        </button>
    </div>
</div>

{{-- Survey Builder يظهر هنا عند الضغط على الزر --}}
{{-- @if($showSurveyBuilder)
    <div class="mb-6 mt-6">
        @livewire('survey-builder')
    </div>
@endif --}}
@endsection
