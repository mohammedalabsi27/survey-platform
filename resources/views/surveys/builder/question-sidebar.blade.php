<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-6">
    <!-- الرسائل -->
    @if(session()->has('sidebar-success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600"></i>
            <span class="text-green-800 text-sm">{{ session('sidebar-success') }}</span>
        </div>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-600"></i>
            <span class="text-red-800 text-sm">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
        <i class="fas fa-plus-circle text-blue-500"></i>
        إضافة سؤال جديد
    </h3>
    
    <div class="space-y-3">
        @foreach(['text', 'textarea', 'choice', 'multiple_choice', 'yes_no', 'rating'] as $type)
        <button wire:click="addQuestion('{{ $type }}')"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                class="w-full bg-{{ $this->getTypeColor($type) }}-50 hover:bg-{{ $this->getTypeColor($type) }}-100 border-2 border-{{ $this->getTypeColor($type) }}-200 border-dashed text-{{ $this->getTypeColor($type) }}-700 p-4 rounded-xl transition-all duration-200 group text-right flex items-center gap-3 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
            
            <div class="w-10 h-10 bg-{{ $this->getTypeColor($type) }}-500 rounded-lg flex items-center justify-center text-white">
                <i class="{{ $this->getTypeIcon($type) }}"></i>
            </div>
            
            <div class="flex-1">
                <div class="font-semibold">{{ $this->getTypeArabic($type) }}</div>
                <div class="text-xs text-{{ $this->getTypeColor($type) }}-600">
                    @switch($type)
                        @case('text')
                            إجابة نصية قصيرة
                            @break
                        @case('textarea')
                            إجابة نصية مفصلة
                            @break
                        @case('choice')
                            اختر خياراً واحداً
                            @break
                        @case('multiple_choice')
                            اختر عدة خيارات
                            @break
                        @case('yes_no')
                            خياران فقط
                            @break
                        @case('rating')
                            تقييم من 1 إلى 5
                            @break
                    @endswitch
                </div>
            </div>
            
            <!-- مؤشر التحميل -->
            <div wire:loading wire:target="addQuestion('{{ $type }}')">
                <i class="fas fa-spinner fa-spin text-{{ $this->getTypeColor($type) }}-500"></i>
            </div>
        </button>
        @endforeach
    </div>

    <!-- نصائح سريعة -->
    <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
        <h4 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
            <i class="fas fa-lightbulb text-yellow-500"></i>
            نصائح سريعة
        </h4>
        <ul class="text-xs text-gray-600 space-y-1">
            <li class="flex items-start gap-2">
                <span class="text-yellow-500 mt-0.5">•</span>
                <span>ابدأ بالأسئلة المهمة أولاً</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-yellow-500 mt-0.5">•</span>
                <span>استخدم أنواعاً مختلفة من الأسئلة</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-yellow-500 mt-0.5">•</span>
                <span>رتب الأسئلة بشكل منطقي</span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-yellow-500 mt-0.5">•</span>
                <span>تجنب الأسئلة الطويلة جداً</span>
            </li>
        </ul>
    </div>
</div>