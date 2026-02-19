@extends('layouts.master')

@section('title', 'استبياناتي')
@section('header', 'استبياناتي')
@section('subheader', 'إدارة جميع استبياناتك في مكان واحد')

{{-- @section('header-actions')
<button wire:click="$dispatch('openCreateModal')" 
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
    <i class="fas fa-plus"></i>
    إنشاء استبيان
</button>
@endsection --}}

@section('content')
    <div class="fade-in">
        <!-- 🎯 مكون Livewire لقائمة الاستبيانات -->
        <livewire:surveys.surveys-list />

        <!-- 🎯 مكون إنشاء الاستبيان -->
        <livewire:surveys.surveys-create />
    </div>
@endsection