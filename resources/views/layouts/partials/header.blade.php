<!-- 🎯 الهيدر الرئيسي -->
<header class="gradient-bg text-white shadow-lg">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- اللوجو واسم التطبيق -->
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-poll text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">استبياني</h1>
                    <p class="text-white/80 text-sm">منصة الاستبيانات الذكية</p>
                </div>
            </div>
            
            <!-- قائمة التنقل + قسم المستخدم -->
            <div class="flex items-center gap-6">
                <!-- قائمة التنقل -->
                @include('layouts.partials.navigation')
                
                <!-- قسم المستخدم -->
                @include('layouts.partials.user-menu')
                
                <!-- زر القائمة للموبايل -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-white text-2xl">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- القائمة المتنقلة -->
    @include('layouts.partials.mobile-menu')
</header>