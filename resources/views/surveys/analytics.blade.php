@extends('master')

@section('title', 'تحليلات: ' . $survey->title)
@section('header', '📊 تحليلات الاستبيان')
@section('subheader', 'تحليل النتائج والإحصائيات التفصيلية')

@section('header-actions')
<div class="flex gap-3">
    <a href="{{ route('surveys.builder', $survey->id) }}" 
       class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 shadow-lg hover:shadow-xl group">
        <i class="fas fa-edit group-hover:scale-110 transition-transform"></i>
        <span class="font-semibold">العودة للمصمم</span>
    </a>
    <a href="{{ route('surveys.fill', $survey->slug) }}" 
       target="_blank"
       class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 shadow-lg hover:shadow-xl group">
        <i class="fas fa-eye group-hover:scale-110 transition-transform"></i>
        <span class="font-semibold">معاينة الاستبيان</span>
    </a>
</div>
@endsection

@section('content')
<div class="p-6">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
        <!-- 🎯 معلومات سريعة عن الاستبيان -->
        <div class="flex items-center gap-4 mb-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white text-xl">
                <i class="fas fa-poll"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-800">{{ $survey->title }}</h2>
                @if($survey->description)
                <p class="text-gray-600 mt-1">{{ $survey->description }}</p>
                @endif
            </div>
            <div class="text-right">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-lg text-sm font-semibold">
                    {{ $survey->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
        
        <!-- 🎯 استدعاء الـ component -->
        <livewire:surveys.survey-analytics :survey="$survey" />
    </div>
</div>
@endsection
@push('scripts')
    <!-- 💡 استدعاء مكتبة ApexCharts للرسوم البيانية -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush