<nav class="hidden md:flex items-center gap-6">
    <!-- أضفنا wire:navigate هنا -->
    <a href="{{ route('dashboard') }}" wire:navigate class="hover:text-white/80 transition-colors flex items-center gap-2 
        {{ request()->routeIs('dashboard') ? 'text-white font-semibold' : '' }}">
        <i class="fas fa-home"></i>
        لوحة التحكم
    </a>
    
    <!-- وأضفنا wire:navigate هنا -->
    <a href="{{ route('surveys.index') }}" wire:navigate class="hover:text-white/80 transition-colors flex items-center gap-2 
        {{ request()->routeIs('surveys.*') ? 'text-white font-semibold' : '' }}">
        <i class="fas fa-list"></i>
        استبياناتي
    </a>
    
    <a href="#" class="hover:text-white/80 transition-colors flex items-center gap-2">
        <i class="fas fa-chart-bar"></i>
        الإحصائيات
    </a>
</nav>