<div class="min-h-screen bg-gray-50/30 p-4">
    <!-- 🎯 رأس المصمم -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white text-lg">
                        <i class="fas fa-poll"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $survey->title }}</h1>
                        <p class="text-gray-600 mt-1">{{ $survey->description ?: 'لا يوجد وصف' }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4 text-sm">
                    <span class="flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full">
                        <i class="fas fa-list"></i>
                        {{ $survey->questions_count ?? $survey->questions->count() }} أسئلة
                    </span>
                    <span class="flex items-center gap-2 px-3 py-1 bg-green-100 text-green-800 rounded-full">
                        <i class="fas fa-users"></i>
                        {{ $survey->responses_count ?? 0 }} مشاركة
                    </span>
                    <span class="flex items-center gap-2 px-3 py-1 {{ $survey->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full">
                        <i class="fas fa-circle text-xs"></i>
                        {{ $survey->status == 'published' ? 'منشور' : 'مسودة' }}
                    </span>
                </div>
            </div>
            
            <div class="flex gap-3">
                <!-- 💡 زر النشر / الإيقاف الجديد -->
                <button wire:click="toggleStatus" 
                        class="px-6 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 shadow-lg hover:shadow-xl font-semibold text-white
                        {{ $survey->status === 'published' ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700' }}">
                    
                    <!-- تغيير الأيقونة والنص بناءً على الحالة -->
                    @if($survey->status === 'published')
                        <i class="fas fa-pause-circle"></i>
                        <span>إيقاف الاستبيان</span>
                    @else
                        <i class="fas fa-globe"></i>
                        <span>نشر الاستبيان</span>
                    @endif
                </button>

                <!-- 💡 زر نسخ الرابط الذكي (يظهر فقط إذا كان الاستبيان منشوراً) -->
                @if($survey->status === 'published')
                <button x-data="{ copied: false }"
                        @click="navigator.clipboard.writeText('{{ route('surveys.fill', $survey->id) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-4 py-3 rounded-xl flex items-center gap-2 transition-all duration-200 border border-indigo-200 shadow-sm"
                        title="نسخ رابط المشاركة">
                    
                    <!-- تغيير الأيقونة عند النسخ -->
                    <i class="fas" :class="copied ? 'fa-check text-green-500' : 'fa-link'"></i>
                    
                    <!-- تغيير النص عند النسخ -->
                    <span x-text="copied ? 'تم النسخ!' : 'نسخ الرابط'" class="font-semibold text-sm"></span>
                </button>
                @endif

                <!-- زر المعاينة -->
                <a href="{{ route('surveys.fill', $survey->id) }}" 
                target="_blank"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 shadow-lg hover:shadow-xl group">
                    <i class="fas fa-eye group-hover:scale-110 transition-transform"></i>
                    <span class="font-semibold">معاينة</span>
                </a>
                
                <!-- زر التحليلات -->
                <a href="{{ route('surveys.analytics', $survey->id) }}" 
                class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 shadow-lg hover:shadow-xl group">
                    <i class="fas fa-chart-bar group-hover:scale-110 transition-transform"></i>
                    <span class="font-semibold">تحليلات</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 🎯 الرسائل -->
    @if(session()->has('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600"></i>
            <span class="text-green-800">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- 🎯 المحتوى الرئيسي -->
    @if($activeTab == 'questions')
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        <!-- الشريط الجانبي -->
        <div class="xl:col-span-1">
            <livewire:surveys.builder.question-sidebar :survey="$survey" />
        </div>

        <!-- منطقة الأسئلة -->
        <div class="xl:col-span-3">
            <livewire:surveys.builder.question-list :survey="$survey" />
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl p-6">
        <p class="text-gray-500">سيظهر محتوى التبويبات الأخرى هنا</p>
    </div>
    @endif
</div>