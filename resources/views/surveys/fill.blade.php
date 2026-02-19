<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ $survey->title }} - استبياني</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            line-height: 1.6;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* تصغير حجم الصفحة قليلاً */
        html {
            zoom: 0.9;
        }

        /* تخصيص شريط التمرير */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="min-h-screen">

    <!-- 🎯 المحتوى -->
    <main class="py-8">
        <div class="max-w-3xl mx-auto px-3 sm:px-4 md:px-6">
            
            <!-- 🎯 رأس الاستبيان -->
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-6 fade-in">
                <div class="text-center">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white text-xl md:text-2xl mx-auto mb-5">
                        <i class="fas fa-poll"></i>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">{{ $survey->title }}</h1>
                    
                    @if($survey->description)
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-4">
                        {{ $survey->description }}
                    </p>
                    @endif

                    <div class="flex flex-wrap justify-center gap-3 text-sm">
                        <div class="bg-blue-100 text-blue-800 px-3 py-1.5 rounded-xl flex items-center gap-1.5">
                            <i class="fas fa-list"></i>
                            {{ $survey->questions_count ?? $survey->questions->count() }} سؤال
                        </div>
                        <div class="bg-green-100 text-green-800 px-3 py-1.5 rounded-xl flex items-center gap-1.5">
                            <i class="fas fa-clock"></i>
                            ~{{ ceil(($survey->questions_count ?? $survey->questions->count()) * 0.5) }} دقيقة
                        </div>
                        <div class="bg-purple-100 text-purple-800 px-3 py-1.5 rounded-xl flex items-center gap-1.5">
                            <i class="fas fa-shield-alt"></i>
                            بيانات محمية
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🎯 نموذج Livewire -->
            <div class="bg-white rounded-2xl shadow-xl fade-in border border-gray-100 overflow-hidden">
                <livewire:surveys.survey-filler :survey="$survey" />
            </div>

            <!-- 🎯 معلومات توعوية -->
            <div class="mt-8 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 p-6 text-white fade-in text-sm md:text-base">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-xl md:text-2xl mb-2"><i class="fas fa-lock"></i></div>
                        <h4 class="font-semibold mb-1">خصوصية كاملة</h4>
                        <p class="text-white/80">بياناتك محمية ولا تُشارك</p>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl mb-2"><i class="fas fa-chart-line"></i></div>
                        <h4 class="font-semibold mb-1">تأثير حقيقي</h4>
                        <p class="text-white/80">مساهمتك تصنع القرار</p>
                    </div>
                    <div>
                        <div class="text-xl md:text-2xl mb-2"><i class="fas fa-hand-holding-heart"></i></div>
                        <h4 class="font-semibold mb-1">مجاني تماماً</h4>
                        <p class="text-white/80">لا توجد أي رسوم للمشاركة</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- 🎯 الفوتر -->
    <footer class="bg-white/10 backdrop-blur-sm border-t border-white/20 mt-10">
        <div class="text-center text-white/70 py-5 text-sm">
            <p>© 2024 استبياني - منصة الاستبيانات الذكية</p>
            <p class="mt-1">شكراً لمشاركتك 🙏</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fadeElements = document.querySelectorAll('.fade-in');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                    }
                });
            }, { threshold: 0.1 });

            fadeElements.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
