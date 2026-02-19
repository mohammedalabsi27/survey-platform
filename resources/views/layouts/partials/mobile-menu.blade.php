<div id="mobile-menu" class="hidden md:hidden bg-white/10 backdrop-blur-sm">
    <div class="container mx-auto px-4 py-4 flex flex-col gap-4">
        <a href="{{ route('dashboard') }}" class="text-white hover:text-white/80 transition-colors flex items-center gap-2">
            <i class="fas fa-home"></i>
            لوحة التحكم
        </a>
        <a href="{{ route('surveys.index') }}" class="text-white hover:text-white/80 transition-colors flex items-center gap-2">
            <i class="fas fa-list"></i>
            استبياناتي
        </a>
        <a href="#" class="text-white hover:text-white/80 transition-colors flex items-center gap-2">
            <i class="fas fa-chart-bar"></i>
            الإحصائيات
        </a>
        
        <!-- قسم المستخدم في الموبايل -->
        <div class="border-t border-white/20 pt-4 mt-2">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <div class="font-semibold">{{ Auth::user()->name ?? 'مستخدم' }}</div>
                    <div class="text-white/70 text-sm">{{ Auth::user()->email ?? '' }}</div>
                </div>
            </div>
            
            <div class="space-y-2">
                <a href="{{-- route('profile.show') --}}" class="block text-white hover:text-white/80 transition-colors flex items-center gap-2">
                    <i class="fas fa-user-circle"></i>
                    الملف الشخصي
                </a>
                <a href="#" class="block text-white hover:text-white/80 transition-colors flex items-center gap-2">
                    <i class="fas fa-cog"></i>
                    الإعدادات
                </a>
                @livewire('auth.logout-component')
            </div>
        </div>
    </div>
</div>