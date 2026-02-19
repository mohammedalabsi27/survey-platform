<div class="relative group">
    <button class="flex items-center gap-3 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-xl transition-all duration-300">
        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
            <i class="fas fa-user text-sm"></i>
        </div>
        <div class="hidden md:block text-right">
            <div class="font-semibold text-sm">
                {{ Auth::user()->name ?? 'مستخدم' }}
            </div>
            <div class="text-xs text-white/70">
                {{ Auth::user()->email ?? '' }}
            </div>
        </div>
        <i class="fas fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
    </button>
    
    <!-- قائمة المستخدم المنسدلة -->
    <div class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right z-50">
        <div class="p-4 border-b border-gray-100">
            <div class="font-semibold text-gray-800 text-sm">
                {{ Auth::user()->name ?? 'مستخدم' }}
            </div>
            <div class="text-gray-500 text-xs truncate">
                {{ Auth::user()->email ?? '' }}
            </div>
        </div>
        
        <div class="p-2">
            <a href="{{-- route('profile.show') --}}" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors">
                <i class="fas fa-user-circle text-gray-400"></i>
                <span class="text-sm">الملف الشخصي</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors">
                <i class="fas fa-cog text-gray-400"></i>
                <span class="text-sm">الإعدادات</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors">
                <i class="fas fa-question-circle text-gray-400"></i>
                <span class="text-sm">المساعدة</span>
            </a>
        </div>
        
        <div class="p-2 border-t border-gray-100">
            @livewire('auth.logout-component')
        </div>
    </div>
</div>