<div class="fade-in">
    <!-- 🎯 شريط البحث والإجراءات -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-6 shadow-sm">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center">
            <!-- شريط البحث -->
            <div class="flex-1 w-full lg:w-auto">
                <div class="relative max-w-md">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="ابحث في استبياناتك..."
                           class="w-full pr-12 pl-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50">
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>
            
            <!-- أزرار الإجراءات -->
            <div class="flex flex-wrap gap-3">
                <!-- زر إنشاء استبيان -->
                <button wire:click="$dispatch('openCreateModal')"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl flex items-center gap-3 transition-all duration-300 shadow-lg hover:shadow-xl group">
                    <i class="fas fa-plus-circle group-hover:scale-110 transition-transform"></i>
                    <span class="font-semibold">إنشاء استبيان جديد</span>
                </button>

                <!-- زر التصفية -->
                <div class="relative group">
                    <button class="bg-white border border-gray-300 text-gray-700 px-4 py-3 rounded-xl flex items-center gap-2 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-filter"></i>
                        <span>تصفية</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 🎯 بطاقات الاستبيانات -->
    @if($surveys->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($surveys as $survey)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 card-hover group">
            <!-- رأس البطاقة -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white">
                            <i class="fas fa-poll"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-1">
                                {{ $survey->title }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="far fa-clock ml-1"></i>
                                @if($survey->created_at)
                                    {{ $survey->created_at->diffForHumans() }}
                                @else
                                    تاريخ غير محدد
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <!-- حالة الاستبيان -->
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                        {{ $survey->status == 'published' 
                            ? 'bg-green-100 text-green-800 border border-green-200' 
                            : 'bg-yellow-100 text-yellow-800 border border-yellow-200' }}">
                        <span class="w-2 h-2 rounded-full mr-2 
                            {{ $survey->status == 'published' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                        {{ $survey->status == 'published' ? 'منشور' : 'مسودة' }}
                    </span>
                </div>

                <!-- الوصف -->
                @if($survey->description)
                <p class="text-gray-600 text-sm line-clamp-2 leading-relaxed">
                    {{ $survey->description }}
                </p>
                @else
                <p class="text-gray-400 text-sm italic">لا يوجد وصف</p>
                @endif
            </div>

            <!-- 🎯 إحصائيات سريعة -->
            <div class="p-4 border-b border-gray-100">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-blue-50 rounded-lg p-3">
                        <div class="text-lg font-bold text-blue-600">{{ $survey->questions_count ?? 0 }}</div>
                        <div class="text-xs text-blue-800">أسئلة</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3">
                        <div class="text-lg font-bold text-green-600">{{ $survey->responses_count ?? 0 }}</div>
                        <div class="text-xs text-green-800">مشاركات</div>
                    </div>
                </div>
            </div>

            <!-- 🎯 أزرار الإجراءات -->
            <div class="p-4">
                <div class="flex justify-between gap-2">
                    <!-- تصميم -->
                    <a href="{{ route('surveys.builder', $survey->id) }}" 
                       class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 p-3 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 group/btn">
                        <i class="fas fa-edit group-hover/btn:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">تصميم</span>
                    </a>
                    
                    <!-- معاينة -->
                    <a href="{{ route('surveys.fill', $survey->slug) }}" 
                       class="flex-1 bg-green-50 hover:bg-green-100 text-green-600 p-3 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 group/btn"
                       target="_blank">
                        <i class="fas fa-eye group-hover/btn:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">معاينة</span>
                    </a>
                    
                    <!-- تحليلات -->
                    <a href="{{ route('surveys.analytics', $survey->id) }}" 
                       class="flex-1 bg-purple-50 hover:bg-purple-100 text-purple-600 p-3 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 group/btn">
                        <i class="fas fa-chart-bar group-hover/btn:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">تحليلات</span>
                    </a>
                </div>

                <!-- زر الحذف -->
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <button 
                        onclick="confirmDelete('{{ $survey->id }}', '{{ $survey->title }}')"
                        class="w-full bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 group/btn">
                        <i class="fas fa-trash group-hover/btn:scale-110 transition-transform"></i>
                        <span class="text-sm font-medium">حذف الاستبيان</span>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- 🎯 الترقيم -->
    @if($surveys->hasPages())
    <div class="bg-white rounded-2xl border border-gray-200 px-6 py-4 mt-6 shadow-sm">
        <div class="flex justify-between items-center">
            <p class="text-sm text-gray-600">
                عرض {{ $surveys->firstItem() }} - {{ $surveys->lastItem() }} من {{ $surveys->total() }} استبيان
            </p>
            <div class="flex gap-2">
                {{ $surveys->links() }}
            </div>
        </div>
    </div>
    @endif

    @else
    <!-- 🎯 حالة عدم وجود استبيانات -->
    <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-300">
        <div class="text-6xl mb-4 text-gray-300">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-500 mb-2">لا توجد استبيانات</h3>
        <p class="text-gray-400 mb-6 max-w-md mx-auto">ابدأ رحلتك بإنشاء أول استبيان لك وجمع الآراء بسهولة</p>
        <button wire:click="$dispatch('openCreateModal')"
                class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-4 rounded-xl inline-flex items-center gap-3 transition-all duration-300 hover:shadow-lg group">
            <i class="fas fa-plus-circle group-hover:scale-110 transition-transform"></i>
            <span class="font-semibold">إنشاء أول استبيان</span>
        </button>
    </div>
    @endif


    <!-- 🎯 ستايل مخصص -->
    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>
<!-- 🎯 سكريبت تأكيد الحذف -->
<script>
function confirmDelete(surveyId, surveyTitle) {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        html: `سيتم حذف الاستبيان: <strong>"${surveyTitle}"</strong> بشكل دائم`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذفه',
        cancelButtonText: 'إلغاء',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            @this.deleteSurvey(surveyId);
        }
    });
}

// إضافة تأثيرات عند التمرير
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card-hover');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
});
</script>