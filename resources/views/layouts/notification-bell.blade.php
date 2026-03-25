<div class="relative" x-data="{ open: false }" wire:poll.30s>
    <!-- 🔔 أيقونة الجرس -->
    <button @click="open = !open" @click.outside="open = false" 
            class="relative p-2 text-white/80 hover:text-white transition-colors rounded-full hover:bg-white/10">
        <i class="fas fa-bell text-xl"></i>
        
        <!-- النقطة الحمراء للعدد -->
        @if($this->unreadNotifications->count() > 0)
        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full animate-pulse">
            {{ $this->unreadNotifications->count() }}
        </span>
        @endif
    </button>

    <!-- 📜 القائمة المنسدلة -->
    <div x-show="open" 
         style="display: none;"
         x-transition.opacity.duration.200ms
         class="absolute left-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
        
        <!-- رأس القائمة -->
        <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">الإشعارات</h3>
            @if($this->unreadNotifications->count() > 0)
            <button wire:click="markAllAsRead" class="text-xs text-blue-600 hover:text-blue-800 font-semibold">
                تحديد الكل كمقروء
            </button>
            @endif
        </div>

        <!-- قائمة الإشعارات -->
        <div class="max-h-80 overflow-y-auto">
            @forelse($this->unreadNotifications as $notification)
            <div wire:click="markAsRead('{{ $notification->id }}')" 
                 class="p-4 border-b border-gray-50 hover:bg-blue-50 cursor-pointer transition-colors flex items-start gap-3 relative group">
                
                <div class="w-10 h-10 bg-{{ $notification->data['color'] ?? 'blue' }}-100 rounded-full flex items-center justify-center text-{{ $notification->data['color'] ?? 'blue' }}-600 shrink-0">
                    <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }}"></i>
                </div>
                
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800">{{ $notification->data['message'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>

                <!-- نقطة زرقاء تدل على أنه غير مقروء -->
                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">
                <i class="far fa-bell-slash text-3xl mb-3 text-gray-300"></i>
                <p class="text-sm">لا توجد إشعارات جديدة</p>
            </div>
            @endforelse
        </div>
        
        <!-- تذييل القائمة -->
        <a href="{{ route('dashboard') }}" class="block p-3 text-center text-sm font-semibold text-gray-600 hover:bg-gray-50 bg-white border-t border-gray-100">
            الذهاب للوحة التحكم
        </a>
    </div>
</div>