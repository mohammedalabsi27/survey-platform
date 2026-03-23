<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 animate-fade-in">
    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
        <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center text-lg">
            <i class="fas fa-cog"></i>
        </div>
        <h2 class="text-xl font-bold text-gray-800">إعدادات الاستبيان الأساسية</h2>
    </div>

    @if(session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form wire:submit="saveSettings" class="space-y-6 max-w-3xl">
        <!-- العنوان والوصف -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">عنوان الاستبيان <span class="text-red-500">*</span></label>
                <input type="text" wire:model="title" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 bg-gray-50">
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">وصف الاستبيان</label>
                <textarea wire:model="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 bg-gray-50"></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <hr class="border-gray-100">

        <!-- إعدادات التاريخ -->
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
            <h3 class="font-semibold text-blue-800 mb-4 flex items-center gap-2">
                <i class="fas fa-calendar-alt"></i> جدول زمني للاستبيان (اختياري)
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ البدء</label>
                    <input type="datetime-local" wire:model="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">متى يبدأ استقبال الردود؟</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الانتهاء (إغلاق تلقائي)</label>
                    <input type="datetime-local" wire:model="end_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">متى يتم إغلاق الاستبيان تلقائياً؟</p>
                    @error('end_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <hr class="border-gray-100">

        <!-- 💡 إعدادات الهوية البصرية (Branding) -->
        <div class="bg-purple-50 border border-purple-100 rounded-xl p-5">
            <h3 class="font-semibold text-purple-800 mb-4 flex items-center gap-2">
                <i class="fas fa-palette"></i> المظهر ورسالة الشكر
            </h3>
            
            <div class="space-y-6">
                <!-- اختيار اللون -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">لون الاستبيان الأساسي</label>
                    <div class="flex flex-wrap gap-4">
                        <!-- أزرق -->
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="theme_color" value="blue" class="sr-only peer">
                            <div class="w-10 h-10 rounded-full bg-blue-500 peer-checked:ring-4 ring-blue-300 ring-offset-2 transition-all"></div>
                        </label>
                        <!-- أخضر -->
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="theme_color" value="green" class="sr-only peer">
                            <div class="w-10 h-10 rounded-full bg-green-500 peer-checked:ring-4 ring-green-300 ring-offset-2 transition-all"></div>
                        </label>
                        <!-- بنفسجي -->
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="theme_color" value="purple" class="sr-only peer">
                            <div class="w-10 h-10 rounded-full bg-purple-500 peer-checked:ring-4 ring-purple-300 ring-offset-2 transition-all"></div>
                        </label>
                        <!-- أحمر / وردي -->
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="theme_color" value="rose" class="sr-only peer">
                            <div class="w-10 h-10 rounded-full bg-rose-500 peer-checked:ring-4 ring-rose-300 ring-offset-2 transition-all"></div>
                        </label>
                        <!-- برتقالي -->
                        <label class="cursor-pointer">
                            <input type="radio" wire:model="theme_color" value="orange" class="sr-only peer">
                            <div class="w-10 h-10 rounded-full bg-orange-500 peer-checked:ring-4 ring-orange-300 ring-offset-2 transition-all"></div>
                        </label>
                    </div>
                </div>

                <!-- رسالة الشكر المخصصة -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">رسالة الشكر (تظهر بعد الإرسال)</label>
                    <textarea wire:model="thank_you_message" rows="2" 
                              placeholder="مثال: شكراً لمشاركتك! يمكنك استخدام كود الخصم (SURVEY50) للحصول على خصم 50%" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"></textarea>
                    <p class="text-xs text-gray-500 mt-1">إذا تركتها فارغة، ستظهر رسالة الشكر الافتراضية.</p>
                </div>
            </div>
        </div>
        <!-- زر الحفظ -->
        <div class="pt-4 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition-colors flex items-center gap-2 shadow-lg">
                <i class="fas fa-save"></i> حفظ التعديلات
            </button>
        </div>
    </form>
</div>