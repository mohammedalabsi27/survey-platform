<nav class="hidden md:flex items-center gap-6">
    <a href="{{ route('dashboard') }}" class="hover:text-white/80 transition-colors flex items-center gap-2 
        {{ request()->routeIs('dashboard') ? 'text-white font-semibold' : '' }}">
        <i class="fas fa-home"></i>
        لوحة التحكم
    </a>
    <a href="{{ route('surveys.index') }}" class="hover:text-white/80 transition-colors flex items-center gap-2 
        {{ request()->routeIs('surveys.*') ? 'text-white font-semibold' : '' }}">
        <i class="fas fa-list"></i>
        استبياناتي
    </a>
    <a href="#" class="hover:text-white/80 transition-colors flex items-center gap-2">
        <i class="fas fa-chart-bar"></i>
        الإحصائيات
    </a>
</nav>