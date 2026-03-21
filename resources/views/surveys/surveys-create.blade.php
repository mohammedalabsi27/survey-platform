<div>
    @if($showModal)
    <!-- 🎯 overlay مع تأثير blur -->
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <!-- overlay مع تأثير blur -->
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300" 
             wire:click="closeModal"></div>
        
        <!-- 🎯 Modal محسّن -->
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95"
             x-data="{ show: true }"
             x-init="setTimeout(() => show = true, 50)"
             x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <!-- 🎯 رأس الـ Modal -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-t-2xl text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">إنشاء استبيان جديد</h2>
                            <p class="text-blue-100 text-sm mt-1">ابدأ رحلتك مع استبيان جديد</p>
                        </div>
                    </div>
                    <button wire:click="closeModal" 
                            class="text-white/80 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-lg">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- 🎯 جسم الـ Modal -->
            <div class="p-6">
                <form wire:submit.prevent="save">
                    <!-- حقل عنوان الاستبيان -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-heading text-blue-500"></i>
                            عنوان الاستبيان
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               wire:model="title"
                               placeholder="أدخل عنواناً جذاباً للاستبيان..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 placeholder-gray-400"
                               autofocus>
                        @error('title')
                        <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>

                    <!-- حقل الوصف -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-align-left text-green-500"></i>
                            وصف الاستبيان
                            <span class="text-gray-400 text-xs">(اختياري)</span>
                        </label>
                        <textarea wire:model="description" 
                                  rows="4"
                                  placeholder="صف موجز عن هدف الاستبيان وما تريد تحقيقه منه..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 placeholder-gray-400 resize-none"></textarea>
                        
                        <!-- عداد الأحرف -->
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-gray-500 text-xs">المشاركين على فهم هدف الاستبيان</p>
                            <span class="text-gray-400 text-xs">{{ strlen($description ?? '') }}/500</span>
                        </div>
                    </div>

                    <!-- 🎯 قسم النصائح -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs mt-0.5">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-blue-800 text-sm mb-1">نصيحة سريعة</h4>
                                <p class="text-blue-700 text-xs">اختر عنواناً واضحاً ووصفاً مختصراً يجذب المشاركين</p>
                            </div>
                        </div>
                    </div>

                    <!-- 🎯 أزرار الإجراءات -->
                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                        <button type="button"
                                wire:click="closeModal"
                                class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-all duration-200 font-semibold flex items-center justify-center gap-2 group">
                            <i class="fas fa-times group-hover:scale-110 transition-transform"></i>
                            إلغاء
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group">
                            <i class="fas fa-save group-hover:scale-110 transition-transform"></i>
                            إنشاء الاستبيان
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 🎯 تأثير منع التمرير عند فتح الـ Modal -->
    <style>
        body {
            overflow: hidden;
        }
    </style>
    @endif
</div>

<!-- 🎯 سكريبتات إضافية -->
<script>
// إغلاق الـ Modal بالزر ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        @this.closeModal();
    }
});

// التركيز التلقائي على حقل العنوان
window.addEventListener('survey-modal-opened', function() {
    const titleInput = document.querySelector('input[wire\\:model="title"]');
    if (titleInput) {
        setTimeout(() => {
            titleInput.focus();
        }, 300);
    }
});

// تأثيرات إضافية للـ inputs
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-blue-200');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-blue-200');
        });
    });
});
</script>