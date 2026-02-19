<!-- 🎯 الفوتر -->
<footer class="bg-gray-800 text-white mt-16">
    <div class="container mx-auto px-4 py-8">
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
                    <li>
                        <a href="{{ url('/') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-home text-xs"></i>
                            الرئيسية
                        </a>
                    </li>
                    @auth
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-tachometer-alt text-xs"></i>
                            لوحة التحكم
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('surveys.index') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-list text-xs"></i>
                            استبياناتي
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('register') }}" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-user-plus text-xs"></i>
                            إنشاء حساب
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
            
            <!-- الدعم -->
            <div>
                <h3 class="text-lg font-bold mb-4">الدعم</h3>
                <ul class="space-y-2 text-gray-400">
                    <li>
                        <a href="#" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-question-circle text-xs"></i>
                            المساعدة
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-file-alt text-xs"></i>
                            الأسئلة الشائعة
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-white transition-colors flex items-center gap-2">
                            <i class="fas fa-envelope text-xs"></i>
                            اتصل بنا
                        </a>
                    </li>
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
                    <a href="#" class="text-gray-400 hover:text-white transition-colors text-xl">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
                
                <!-- معلومات الاتصال -->
                <div class="mt-4 space-y-2 text-gray-400 text-sm">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-envelope text-xs"></i>
                        <span>info@estebani.com</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-phone text-xs"></i>
                        <span>+966 12 345 6789</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- حقوق النشر -->
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
            <p>&copy; 2024 استبياني. جميع الحقوق محفوظة.</p>
            <p class="text-xs mt-1">تم التطوير بشغف ❤️ لتسهيل عملية البحث والاستبيانات</p>
        </div>
    </div>
</footer>