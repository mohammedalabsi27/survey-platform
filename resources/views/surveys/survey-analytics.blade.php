<div class="space-y-6">
    <!-- 🎯 بطاقات الإحصائيات الرئيسية -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- إجمالي المشاركات -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-sm mb-2">إجمالي المشاركات</p>
                    <h3 class="text-3xl font-bold">{{ $stats['total_responses'] }}</h3>
                    <p class="text-blue-100 text-xs mt-2">عدد المشاركين</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <!-- عدد الأسئلة -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-green-100 text-sm mb-2">عدد الأسئلة</p>
                    <h3 class="text-3xl font-bold">{{ $stats['total_questions'] }}</h3>
                    <p class="text-green-100 text-xs mt-2">أسئلة الاستبيان</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-list-alt text-xl"></i>
                </div>
            </div>
        </div>

        <!-- نسبة الإكمال -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-purple-100 text-sm mb-2">نسبة الإكمال</p>
                    <h3 class="text-3xl font-bold">{{ $stats['completion_rate'] }}</h3>
                    <p class="text-purple-100 text-xs mt-2">معدل الإنجاز</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-percentage text-xl"></i>
                </div>
            </div>
        </div>

        <!-- متوسط الوقت -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-orange-100 text-sm mb-2">متوسط الوقت</p>
                    <h3 class="text-3xl font-bold">{{ $stats['avg_time'] }}</h3>
                    <p class="text-orange-100 text-xs mt-2">دقائق لكل مشارك</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- 🎯 المشاركات الحديثة -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                            <i class="fas fa-history"></i>
                        </div>
                        المشاركات الحديثة
                    </h3>
                    <span class="text-gray-500 text-sm">آخر 7 أيام</span>
                </div>

                @if($survey->responses->count() > 0)
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @foreach($survey->responses->take(10) as $response)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">مشاركة #{{ $response->id }}</p>
                                <p class="text-gray-500 text-sm">{{ $response->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-lg text-sm font-medium group-hover:scale-105 transition-transform">
                            {{ $response->answers->count() }} إجابة
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <div class="text-4xl mb-3 text-gray-300">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <p class="text-lg">لا توجد مشاركات بعد</p>
                    <p class="text-sm mt-1">شارك رابط الاستبيان لبدء جمع الإجابات</p>
                </div>
                @endif
            </div>
        </div>

        <!-- 🎯 تحليل الأسئلة -->
        <div class="xl:col-span-2">
            <div class="space-y-6">
                @foreach($survey->questions as $question)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 question-analytics-card">
                    <!-- رأس السؤال -->
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $question->question_text }}</h3>
                                <div class="flex items-center gap-3 text-sm text-gray-500">
                                    <span class="bg-gray-100 px-3 py-1 rounded-lg">
                                        <i class="fas fa-tag ml-1"></i>
                                        {{ $this->getQuestionTypeText($question->type) }}
                                    </span>
                                    <span class="text-gray-400">
                                        <i class="fas fa-chart-bar ml-1"></i>
                                        {{ $question->answers->count() }} إجابة
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 🎯 محتوى التحليل حسب نوع السؤال -->
                    <div class="analytics-content">
                        @if(in_array($question->type, ['text', 'textarea']))
                        <!-- 📝 تحليل الأسئلة النصية (كما هو) -->
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-comment-dots text-blue-500"></i> الإجابات النصية
                            </h4>
                            @php $textAnswers = $this->getTextAnswers($question); @endphp
                            
                            @if($textAnswers && $textAnswers->count() > 0)
                            <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                                @foreach($textAnswers as $answer)
                                <div class="p-4 border border-gray-200 rounded-xl bg-gray-50 hover:bg-white transition-colors">
                                    <p class="text-gray-700 leading-relaxed">{{ $answer->answer_text }}</p>
                                    <p class="text-gray-500 text-xs mt-2">{{ $answer->created_at->diffForHumans() }}</p>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-6 text-gray-500 bg-gray-100 rounded-xl">
                                <i class="fas fa-comment-slash text-2xl mb-2"></i>
                                <p>لا توجد إجابات نصية بعد</p>
                            </div>
                            @endif
                        </div>

                        @elseif($question->type == 'choice' || $question->type == 'multiple_choice')
                        <!-- 🔘☑️ تحليل الاختيارات (دائرة تفاعلية) -->
                        @php 
                            $stats = $question->type == 'choice' ? $this->getChoiceStats($question) : $this->getMultipleChoiceStats($question); 
                        @endphp
                        @if($stats && count($stats) > 0)
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-chart-pie text-blue-500"></i> توزيع الإجابات
                            </h4>
                            <!-- 💡 الحل هنا: استخدمنا علامة التنصيص المفردة ' لـ x-data -->
                            <div wire:ignore class="flex justify-center" x-data='{
                                init() {
                                    let options = {
                                        chart: { type: "donut", height: 320, fontFamily: "Tajawal, sans-serif" },
                                        series: {!! json_encode(array_column($stats, "count"), JSON_NUMERIC_CHECK) !!},
                                        labels: {!! json_encode(array_column($stats, "option"), JSON_UNESCAPED_UNICODE) !!},
                                        colors:["#3b82f6", "#10b981", "#f59e0b", "#ef4444", "#8b5cf6", "#ec4899"],
                                        dataLabels: { enabled: true },
                                        legend: { position: "bottom" }
                                    };
                                    new ApexCharts(this.$refs.myChart, options).render();
                                }
                            }'>
                                <div x-ref="myChart"></div>
                            </div>
                        </div>
                        @endif

                        @elseif($question->type == 'yes_no')
                        <!-- 👍👎 تحليل نعم/لا (دائرة تفاعلية) -->
                        @php $yesNoStats = $this->getYesNoStats($question); @endphp
                        @if($yesNoStats)
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-balance-scale text-green-500"></i> نتائج نعم/لا
                            </h4>
                            <div wire:ignore class="flex justify-center" x-data='{
                                init() {
                                    let options = {
                                        chart: { type: "pie", height: 300, fontFamily: "Tajawal, sans-serif" },
                                        series: [{!! $yesNoStats["نعم"]["count"] !!}, {!! $yesNoStats["لا"]["count"] !!}],
                                        labels: ["نعم 👍", "لا 👎"],
                                        colors:["#10b981", "#ef4444"],
                                        dataLabels: { enabled: true, style: { fontSize: "16px" } },
                                        legend: { position: "bottom", fontSize: "15px" }
                                    };
                                    new ApexCharts(this.$refs.myChart, options).render();
                                }
                            }'>
                                <div x-ref="myChart"></div>
                            </div>
                        </div>
                        @endif

                        @elseif($question->type == 'rating')
                        <!-- ⭐ تحليل التقييم (أعمدة تفاعلية) -->
                        @php $ratingStats = $this->getRatingStats($question); @endphp
                        @if($ratingStats && $ratingStats['total_votes'] > 0)
                        <div class="space-y-4">
                            <div class="text-center mb-2">
                                <div class="text-3xl font-bold text-yellow-600">{{ $ratingStats['average'] }} / 5</div>
                                <div class="text-gray-500 text-sm">من {{ $ratingStats['total_votes'] }} تقييم</div>
                            </div>
                            <div wire:ignore class="w-full" x-data='{
                                init() {
                                    let options = {
                                        chart: { type: "bar", height: 280, fontFamily: "Tajawal, sans-serif", toolbar: { show: false } },
                                        series:[{ name: "عدد التقييمات", data:[
                                            {!! $ratingStats["ratings"][1]["count"] !!},
                                            {!! $ratingStats["ratings"][2]["count"] !!},
                                            {!! $ratingStats["ratings"][3]["count"] !!},
                                            {!! $ratingStats["ratings"][4]["count"] !!},
                                            {!! $ratingStats["ratings"][5]["count"] !!}
                                        ] }],
                                        xaxis: { categories:["نجمة 1", "نجمتان 2", "3 نجوم", "4 نجوم", "5 نجوم"] },
                                        colors: ["#f59e0b"],
                                        plotOptions: { bar: { borderRadius: 4, distributed: true } },
                                        dataLabels: { enabled: true },
                                        legend: { show: false }
                                    };
                                    new ApexCharts(this.$refs.myChart, options).render();
                                }
                            }'>
                                <div x-ref="myChart"></div>
                            </div>
                        </div>
                        @endif

                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 🎯 أزرار التنقل والتصدير -->
    <div class="text-center pt-6">
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('surveys.builder', $survey->id) }}" 
               class="bg-blue-500 text-white px-8 py-4 rounded-xl hover:bg-blue-600 transition-colors shadow-lg hover:shadow-xl flex items-center gap-3 font-semibold">
               <i class="fas fa-arrow-right"></i>
               العودة للمصمم
            </a>
            
            <a href="{{ route('surveys.fill', $$survey->slug) }}" 
               target="_blank"
               class="bg-green-500 text-white px-8 py-4 rounded-xl hover:bg-green-600 transition-colors shadow-lg hover:shadow-xl flex items-center gap-3 font-semibold">
               <i class="fas fa-eye"></i>
               معاينة الاستبيان
            </a>
            
            <button onclick="window.print()" 
                    class="bg-purple-500 text-white px-8 py-4 rounded-xl hover:bg-purple-600 transition-colors shadow-lg hover:shadow-xl flex items-center gap-3 font-semibold">
               <i class="fas fa-print"></i>
               طباعة التقرير
            </button>

            <!-- 💡 زر تصدير النتائج (Excel/CSV) -->
            <button wire:click="exportResponses" 
                    wire:loading.attr="disabled"
                    class="bg-emerald-600 text-white px-8 py-4 rounded-xl hover:bg-emerald-700 transition-colors shadow-lg hover:shadow-xl flex items-center gap-3 font-semibold disabled:opacity-50">
               <span wire:loading.remove wire:target="exportResponses">
                   <i class="fas fa-file-excel"></i>
                   تصدير Excel
               </span>
               <span wire:loading wire:target="exportResponses">
                   <i class="fas fa-spinner fa-spin"></i>
                   جاري التصدير...
               </span>
            </button>
        </div>
    </div>

</div> <!-- نهاية الحاوية الرئيسية -->

<!-- 🎯 السكريبتات -->
<script>
// تأثيرات الظهور عند التمرير
document.addEventListener('DOMContentLoaded', function() {
    const analyticsCards = document.querySelectorAll('.question-analytics-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    analyticsCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
});

// 💡 قمنا بمسح كود setInterval القديم لأننا استبدلناه بـ wire:poll الخفيف والآمن!
</script>