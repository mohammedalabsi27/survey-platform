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
                        @click="navigator.clipboard.writeText('{{ route('surveys.fill', $survey->slug) }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-4 py-3 rounded-xl flex items-center gap-2 transition-all duration-200 border border-indigo-200 shadow-sm"
                        title="نسخ رابط المشاركة">
                    
                    <!-- تغيير الأيقونة عند النسخ -->
                    <i class="fas" :class="copied ? 'fa-check text-green-500' : 'fa-link'"></i>
                    
                    <!-- تغيير النص عند النسخ -->
                    <span x-text="copied ? 'تم النسخ!' : 'نسخ الرابط'" class="font-semibold text-sm"></span>
                </button>
                <button @click="$dispatch('open-qr-modal')"
                        class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-3 rounded-xl flex items-center gap-2 transition-all duration-200 border border-gray-200 shadow-sm"
                        title="عرض كود QR للطباعة">
                    <i class="fas fa-qrcode text-lg"></i>
                    <span class="font-semibold text-sm hidden sm:inline">كود QR</span>
                </button>
                @endif

                <!-- زر المعاينة -->
                <a href="{{ route('surveys.fill', $survey->slug) }}" 
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

    <div class="flex gap-4 mb-6 border-b border-gray-200 pb-px">
        <button wire:click="changeTab('questions')" 
                class="pb-3 px-2 font-semibold text-lg transition-colors border-b-2 {{ $activeTab == 'questions' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            <i class="fas fa-list-ul ml-2"></i> الأسئلة
        </button>
        
        <button wire:click="changeTab('settings')" 
                class="pb-3 px-2 font-semibold text-lg transition-colors border-b-2 {{ $activeTab == 'settings' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            <i class="fas fa-cog ml-2"></i> الإعدادات
        </button>
    </div>
    
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
    @elseif($activeTab == 'settings')
        <livewire:surveys.builder.survey-settings :survey="$survey" />
    @endif
    
    <!-- 🎯 نافذة كود QR (Modal) -->
    <div x-data="{ show: false }"
        x-show="show"
        @open-qr-modal.window="show = true"
        style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center">
        
        <!-- 💡 خلفية داكنة مع تأثير Blur -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
            @click="show = false" 
            x-transition.opacity></div>
        
        <!-- 💡 صندوق الـ Modal -->
        <div class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center transform transition-all"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-8 scale-95">
            
            <!-- زر الإغلاق -->
            <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                <i class="fas fa-times"></i>
            </button>

            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-800 text-3xl mx-auto mb-4 shadow-inner">
                <i class="fas fa-qrcode"></i>
            </div>
            
            <h3 class="text-xl font-bold text-gray-800 mb-2">كود المشاركة السريع</h3>
            <p class="text-gray-500 text-sm mb-6">امسح الكود بكاميرا الجوال للوصول المباشر إلى الاستبيان</p>
            
            <!-- 💡 صورة الـ QR من API موثوق -->
            <div class="bg-white p-4 rounded-2xl border-2 border-dashed border-gray-200 inline-block mb-6 shadow-sm hover:shadow-md transition-shadow">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('surveys.fill', $survey->slug)) }}" 
                    alt="QR Code" class="w-48 h-48 mx-auto"
                    title="امسح!">
            </div>
            
            <!-- 💡 زر التحميل المباشر كصورة -->
            <button wire:click="downloadQRCode" 
                    wire:loading.attr="disabled"
                    class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition-all shadow-lg hover:shadow-xl group disabled:opacity-70">
                
                <!-- الحالة الطبيعية للزر -->
                <span wire:loading.remove wire:target="downloadQRCode" class="flex items-center gap-2">
                    <i class="fas fa-download group-hover:-translate-y-1 transition-transform"></i>
                    تحميل الكود كصورة (PNG)
                </span>
                
                <!-- حالة التحميل (أثناء جلب الصورة) -->
                <span wire:loading wire:target="downloadQRCode" class="flex items-center gap-2">
                    <i class="fas fa-spinner fa-spin"></i>
                    جاري التحميل...
                </span>
            </button>
        </div>
    </div>
</div>
