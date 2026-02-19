<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استبياني - منصة الاستبيانات الذكية</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts - Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- 🎯 الهيدر البسيط -->
    <header class="gradient-bg text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- اللوجو -->
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-poll text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold">استبياني</h1>
                </div>
                
                <!-- أزرار التسجيل والدخول -->
                <div class="flex gap-3">
                    <a href="{{ route('login') }}" class="px-6 py-2 text-white hover:bg-white/10 rounded-lg transition-colors font-semibold">
                        تسجيل الدخول
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition-colors font-semibold shadow-lg">
                        ابدأ مجاناً
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- 🎯 القسم البطولي (Hero) -->
    <section class="gradient-bg text-white py-20 md:py-32">
        <div class="container mx-auto px-4 text-center">
            <div class="fade-in max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    أنشئ استبياناتك
                    <span class="text-yellow-300">باحترافية</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-90 leading-relaxed">
                    منصة عربية متكاملة لإنشاء وتحليل الاستبيانات بسهولة فائقة
                    <br>
                    <span class="text-lg opacity-80">اصنع استبيانات تفاعلية وجمع النتائج في دقائق</span>
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('register') }}" 
                       class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 shadow-2xl transition-all duration-300 transform hover:scale-105">
                       🚀 ابدأ مجاناً
                    </a>
                    <a href="#features" 
                       class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white/10 transition-all duration-300">
                       📊 اعرف المزيد
                    </a>
                </div>
            </div>
            
            <!-- صورة توضيحية -->
            <div class="fade-in mt-16 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-xl p-6 text-gray-800 text-center shadow-lg">
                            <div class="text-3xl mb-3">📝</div>
                            <h3 class="font-bold mb-2">أنشئ استبيان</h3>
                            <p class="text-sm text-gray-600">اختر من بين أنواع متعددة للأسئلة</p>
                        </div>
                        <div class="bg-white rounded-xl p-6 text-gray-800 text-center shadow-lg">
                            <div class="text-3xl mb-3">🔗</div>
                            <h3 class="font-bold mb-2">شارك الرابط</h3>
                            <p class="text-sm text-gray-600">انشر استبيانك بسهولة</p>
                        </div>
                        <div class="bg-white rounded-xl p-6 text-gray-800 text-center shadow-lg">
                            <div class="text-3xl mb-3">📊</div>
                            <h3 class="font-bold mb-2">حلل النتائج</h3>
                            <p class="text-sm text-gray-600">احصل على تقارير مفصلة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🎯 قسم المزايا -->
    <section id="features" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 fade-in">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">لماذا تختار استبياني؟</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">منصة مصممة خصيصاً لتلبية جميع احتياجاتك في البحث والاستبيانات</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- ميزة 1 -->
                <div class="card-hover bg-gray-50 rounded-2xl p-8 text-center fade-in">
                    <div class="text-5xl mb-4">🎨</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">سهولة الاستخدام</h3>
                    <p class="text-gray-600">واجهة عربية بديهية لا تحتاج إلى خبرة تقنية</p>
                </div>
                
                <!-- ميزة 2 -->
                <div class="card-hover bg-gray-50 rounded-2xl p-8 text-center fade-in">
                    <div class="text-5xl mb-4">📱</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">متجاوز مع جميع الأجهزة</h3>
                    <p class="text-gray-600">تصميم متكامل يعمل على الكمبيوتر والجوال</p>
                </div>
                
                <!-- ميزة 3 -->
                <div class="card-hover bg-gray-50 rounded-2xl p-8 text-center fade-in">
                    <div class="text-5xl mb-4">⚡</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">نتائج فورية</h3>
                    <p class="text-gray-600">احصل على التحليلات والتقارير مباشرة</p>
                </div>
                
                <!-- ميزة 4 -->
                <div class="card-hover bg-gray-50 rounded-2xl p-8 text-center fade-in">
                    <div class="text-5xl mb-4">🔒</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">آمن وموثوق</h3>
                    <p class="text-gray-600">بياناتك محمية بأعلى معايير الأمان</p>
                </div>
                
                <!-- ميزة 5 -->
                <div class="card-hover bg-gray-50 rounded-2xl p-8 text-center fade-in">
                    <div class="text-5xl mb-4">🎯</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">أنواع متعددة من الأسئلة</h3>
                    <p class="text-gray-600">نص، اختيار، تقييم، نعم/لا، وأكثر</p>
                </div>
                
                <!-- ميزة 6 -->
                <div class="card-hover bg-gray-50 rounded-2xl p-8 text-center fade-in">
                    <div class="text-5xl mb-4">💼</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">مناسب للجميع</h3>
                    <p class="text-gray-600">للأفراد، الباحثين، والشركات</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 🎯 قسم كيف تعمل المنصة -->
    <section class="py-20 bg-gradient-to-br from-blue-50 to-purple-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 fade-in">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">كيف تعمل المنصة؟</h2>
                <p class="text-xl text-gray-600">3 خطوات بسيطة تفصلك عن استبيانك الأول</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- خطوة 1 -->
                <div class="text-center fade-in">
                    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center text-2xl font-bold text-blue-600 mx-auto mb-4 shadow-lg">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">أنشئ حسابك</h3>
                    <p class="text-gray-600">سجل في دقائق وابدأ فوراً</p>
                </div>
                
                <!-- خطوة 2 -->
                <div class="text-center fade-in">
                    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center text-2xl font-bold text-blue-600 mx-auto mb-4 shadow-lg">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">صمم استبيانك</h3>
                    <p class="text-gray-600">اختر الأسئلة المناسبة لاحتياجاتك</p>
                </div>
                
                <!-- خطوة 3 -->
                <div class="text-center fade-in">
                    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center text-2xl font-bold text-blue-600 mx-auto mb-4 shadow-lg">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">شارك وحلل</h3>
                    <p class="text-gray-600">انشر رابط الاستبيان واحصل على النتائج</p>
                </div>
            </div>
            
            <!-- زر البدء -->
            <div class="text-center mt-12 fade-in">
                <a href="{{ route('register') }}" 
                   class="bg-blue-600 text-white px-12 py-4 rounded-lg font-bold text-lg hover:bg-blue-700 transition-colors shadow-lg">
                   ابدأ رحلتك الآن 🚀
                </a>
            </div>
        </div>
    </section>

    <!-- 🎯 قسم الإحصائيات -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="fade-in">
                    <div class="text-3xl font-bold text-blue-600 mb-2">+500</div>
                    <div class="text-gray-600">مستخدم نشط</div>
                </div>
                <div class="fade-in">
                    <div class="text-3xl font-bold text-green-600 mb-2">+2,000</div>
                    <div class="text-gray-600">استبيان منشور</div>
                </div>
                <div class="fade-in">
                    <div class="text-3xl font-bold text-purple-600 mb-2">+50,000</div>
                    <div class="text-gray-600">إجابة مجمعة</div>
                </div>
                <div class="fade-in">
                    <div class="text-3xl font-bold text-orange-600 mb-2">+95%</div>
                    <div class="text-gray-600">رضى العملاء</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🎯 قسم الدعوة النهائية -->
    <section class="py-20 gradient-bg text-white text-center">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto fade-in">
                <h2 class="text-4xl font-bold mb-6">جاهز لبدء رحلتك مع الاستبيانات؟</h2>
                <p class="text-xl mb-8 opacity-90">انضم إلى الآلاف من المستخدمين الذين يثقون بنا</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" 
                       class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition-colors">
                       🎯 ابدأ مجاناً
                    </a>
                    <a href="{{ route('login') }}" 
                       class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white/10 transition-colors">
                       لديك حساب؟ سجل دخول
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 🎯 الفوتر -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- معلومات -->
                <div>
                    <h3 class="text-lg font-bold mb-4">استبياني</h3>
                    <p class="text-gray-400">منصة عربية متكاملة لإنشاء وإدارة الاستبيانات بسهولة واحترافية.</p>
                </div>
                
                <!-- روابط سريعة -->
                <div>
                    <h3 class="text-lg font-bold mb-4">روابط سريعة</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ url('/') }}" class="hover:text-white transition-colors">الرئيسية</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">المزايا</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">تسجيل الدخول</a></li>
                    </ul>
                </div>
                
                <!-- الدعم -->
                <div>
                    <h3 class="text-lg font-bold mb-4">الدعم</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">الأسئلة الشائعة</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">اتصل بنا</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">الشروط والأحكام</a></li>
                    </ul>
                </div>
                
                <!-- وسائل التواصل -->
                <div>
                    <h3 class="text-lg font-bold mb-4">تابعنا</h3>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors text-xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors text-xl">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors text-xl">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- حقوق النشر -->
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>© 2024 استبياني. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- 🎯 السكريبتات -->
    <script>
        // تأثيرات الظهور
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            fadeElements.forEach(el => observer.observe(el));
        });

        // تنعيم التمرير للروابط
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>