
@extends('layouts.master')

@section('title', 'لوحة التحكم')
@section('header', 'لوحة التحكم')
@section('subheader', 'نظرة عامة على استبياناتك وأدائك')

@section('content')
    <div class="space-y-6">
        <!-- 🎯 بطاقات الإحصائيات السريعة -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- إجمالي الاستبيانات -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-100 text-sm">إجمالي الاستبيانات</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $totalSurveys ?? 0 }}</h3>
                        <p class="text-blue-100 text-xs mt-2">جميع الاستبيانات</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-poll text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- المشاركات النشطة -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-green-100 text-sm">المشاركات النشطة</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $activeSurveys ?? 0 }}</h3>
                        <p class="text-green-100 text-xs mt-2">استبيانات منشورة</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- إجمالي الردود -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-purple-100 text-sm">إجمالي الردود</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $totalResponses ?? 0 }}</h3>
                        <p class="text-purple-100 text-xs mt-2">جميع المشاركات</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-chart-bar text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- متوسط المشاركة -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-2xl p-6 shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-orange-100 text-sm">متوسط المشاركة</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $avgCompletion ?? 0 }}%</h3>
                        <p class="text-orange-100 text-xs mt-2">نسبة الإكمال</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-percentage text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🎯 الإجراءات السريعة -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('surveys.index') }}" 
            class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 group">
                <div class="text-3xl mb-3 text-blue-500 group-hover:scale-110 transition-transform">
                    <i class="fas fa-list"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">جميع الاستبيانات</h3>
                <p class="text-gray-600 text-sm">إدارة استبياناتك</p>
            </a>

            <a href="{{ route('surveys.index') }}" 
            class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 group">
                <div class="text-3xl mb-3 text-green-500 group-hover:scale-110 transition-transform">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">استبيان جديد</h3>
                <p class="text-gray-600 text-sm">إنشاء استبيان</p>
            </a>

            <a href="#" 
            class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 group">
                <div class="text-3xl mb-3 text-purple-500 group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">التقارير</h3>
                <p class="text-gray-600 text-sm">عرض التحليلات</p>
            </a>

            <a href="#" 
            class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 group">
                <div class="text-3xl mb-3 text-orange-500 group-hover:scale-110 transition-transform">
                    <i class="fas fa-cog"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">الإعدادات</h3>
                <p class="text-gray-600 text-sm">إعدادات الحساب</p>
            </a>
        </div>

        <!-- 💡 الرسم البياني: أداء آخر 7 أيام -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-500"></i> أداء الاستبيانات (آخر 7 أيام)
            </h2>
            <div x-data='{
                init() {
                    let options = {
                        chart: { type: "area", height: 300, fontFamily: "Tajawal, sans-serif", toolbar: { show: false } },
                        series:[{ name: "عدد الردود", data: {{ json_encode($chartData) }} }],
                        xaxis: { categories: {!! json_encode($chartDates) !!} },
                        colors: ["#3b82f6"],
                        fill: { type: "gradient", gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [50, 100] } },
                        dataLabels: { enabled: false },
                        stroke: { curve: "smooth", width: 3 },
                        tooltip: { theme: "light" }
                    };
                    new ApexCharts(this.$refs.mainChart, options).render();
                }
            }'>
                <div x-ref="mainChart"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- 📋 آخر الاستبيانات -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">آخر الاستبيانات</h2>
                    <a href="{{ route('surveys.index') }}" class="text-blue-500 hover:text-blue-600 text-sm font-semibold">
                        عرض الكل
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($recentSurveys as $survey)
                    <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                                <i class="fas fa-poll"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $survey->title }}</h4>
                                <p class="text-gray-500 text-sm">
                                    {{--  --}}
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $survey->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $survey->status == 'published' ? 'منشور' : 'مسودة' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-clipboard-list text-4xl mb-3 text-gray-300"></i>
                        <p>لا توجد استبيانات بعد</p>
                        <a href="{{ route('surveys.index') }}" class="text-blue-500 hover:text-blue-600 text-sm mt-2 inline-block">
                            أنشئ أول استبيان
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- 📊 النشاط الأخير -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">النشاط الأخير</h2>
                    <span class="text-gray-500 text-sm">آخر 7 أيام</span>
                </div>

                <div class="space-y-4">
                    @forelse($recentActivity as $activity)
                    <div class="flex items-center gap-4 p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-10 h-10 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center text-{{ $activity['color'] }}-600 text-lg shrink-0">
                            <i class="fas fa-{{ $activity['icon'] }}"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-800 text-sm font-semibold">{{ $activity['message'] }}</p>
                            <p class="text-gray-500 text-xs mt-1 flex items-center gap-1">
                                <i class="far fa-clock"></i> {{ $activity['diff'] }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-history text-4xl mb-3 text-gray-300"></i>
                        <p>لا يوجد نشاط حديث</p>
                        <p class="text-sm mt-1">سيظهر النشاط هنا عند نشر الاستبيانات وتلقي الردود</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- 🎯 استبيانات تحتاج الانتباه -->
        @if($surveysNeedingAttention->count() > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h2 class="text-xl font-bold text-yellow-800">تحتاج انتباهك</h2>
            </div>

            <div class="space-y-3">
                @foreach($surveysNeedingAttention as $survey)
                <div class="flex justify-between items-center p-3 bg-white rounded-lg border border-yellow-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-600">
                            <i class="fas fa-poll"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $survey->title }}</h4>
                            <p class="text-yellow-600 text-sm">لا توجد مشاركات بعد</p>
                        </div>
                    </div>
                    <a href="{{ route('surveys.builder', $survey->id) }}" 
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600 transition-colors">
                    تحرير
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>    
@endsection
@push('scripts')
    <!-- 💡 استدعاء مكتبة ApexCharts للرسوم البيانية -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush