<div class="space-y-4">
    <!-- 🎯 رسائل -->
    @if(session()->has('list-success'))
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <p class="text-blue-700">{{ session('list-success') }}</p>
    </div>
    @endif
    
    

    <!-- 🎯 شريط التقدم -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">قائمة الأسئلة</h3>
            <div class="flex items-center gap-4 text-sm text-gray-600">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                    {{ $questions->count() }} سؤال
                </span>
            </div>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-2">
            @php
                $progress = $questions->count() > 0 ? min(100, ($questions->count() / 10) * 100) : 0;
            @endphp
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500" 
                 style="width: {{ $progress }}%"></div>
        </div>
        <p class="text-xs text-gray-500 mt-2 text-left">اكتمال الاستبيان: {{ round($progress) }}%</p>
    </div>

    <!-- 💡 استدعاء مكتبة السحب والإفلات -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <!-- 🎯 قائمة الأسئلة (الذكية) -->
    <div class="space-y-4"
         x-data="{
            initSortable() {
                new Sortable(this.$refs.sortableList, {
                    animation: 200,
                    handle: '.drag-handle',
                    ghostClass: 'opacity-50',
                    onEnd: (evt) => {
                        let orderedIds = Array.from(this.$refs.sortableList.children)
                                            .map(item => item.getAttribute('data-id'))
                                            .filter(id => id !== null);
                        
                        $wire.updateQuestionOrder(orderedIds);
                    }
                });
            }
         }"
         x-init="initSortable()"
         x-ref="sortableList">
         
        @forelse($questions as $question)
        <!-- 💡 بطاقة السؤال -->
        <div class="bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 question-card"
             wire:key="question-{{ $question->id }}"
             data-id="{{ $question->id }}">
            
            <!-- رأس السؤال -->
            <div class="p-4 border-b border-gray-100">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex items-start gap-3 flex-1">
                        
                        <!-- 💡 مقبض السحب والإفلات -->
                        <div class="drag-handle w-8 h-8 flex items-center justify-center text-gray-400 hover:text-blue-500 cursor-move transition-colors bg-gray-50 hover:bg-blue-50 rounded-lg shrink-0 mt-1" title="اسحب لترتيب السؤال">
                            <i class="fas fa-grip-vertical"></i>
                        </div>

                        <!-- رقم السؤال -->
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white text-sm font-bold shadow-sm shrink-0 mt-1">
                            {{ $loop->iteration }}
                        </div>

                        <!-- 💡 محتوى السؤال (الحفظ التلقائي) -->
                        <div class="flex-1">
                            <input type="text" 
                                   value="{{ $question->question_text }}"
                                   wire:blur="updateQuestionText({{ $question->id }}, $event.target.value)"
                                   class="w-full font-semibold text-gray-800 bg-transparent border-none focus:ring-0 focus:border-b-2 focus:border-blue-500 hover:bg-gray-50 px-2 py-1 rounded transition-colors text-lg"
                                   placeholder="اكتب نص السؤال هنا...">
                                   
                            <div class="flex items-center gap-2 text-xs text-gray-500 px-2 mt-1">
                                <span class="bg-gray-100 px-2 py-1 rounded">
                                    <i class="fas fa-tag ml-1"></i>
                                    {{ $this->getTypeArabic($question->type) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 💡 أزرار التحكم (مطلوب + حذف) -->
                    <div class="flex items-center gap-4 shrink-0 mt-2">
                        <!-- مفتاح (مطلوب/اختياري) -->
                        <label class="flex items-center cursor-pointer group">
                            <div class="ml-2 text-sm font-semibold {{ $question->required ? 'text-blue-600' : 'text-gray-400' }} transition-colors">
                                مطلوب
                            </div>
                            <div class="relative">
                                <input type="checkbox" class="sr-only" 
                                       wire:click="toggleRequired({{ $question->id }})"
                                       {{ $question->required ? 'checked' : '' }}>
                                <div class="block w-10 h-6 rounded-full transition-colors duration-300 {{ $question->required ? 'bg-blue-500' : 'bg-gray-200' }}"></div>
                                <div class="dot absolute right-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-300 {{ $question->required ? '-translate-x-4' : 'translate-x-0' }}"></div>
                            </div>
                        </label>

                        <div class="w-px h-6 bg-gray-200"></div>

                        <!-- زر الحذف -->
                        <button onclick="confirmDeleteQuestion({{ $question->id }}, '{{ addslashes($question->question_text) }}')"
                                class="px-3 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-sm flex items-center gap-1 transition-colors group">
                            <i class="fas fa-trash text-xs group-hover:scale-110 transition-transform"></i>
                            حذف
                        </button>
                    </div>
                </div>
            </div>

            <!-- 🎯 معاينة السؤال وخياراته -->
            <div class="p-4">
                @include('surveys.partials.question-types', ['question' => $question])

                @if(in_array($question->type, ['choice', 'multiple_choice']))
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <livewire:surveys.builder.option-manager 
                        :question="$question" 
                        :key="'options-' . $question->id" />
                </div>
                @endif
            </div>
        </div>
        @empty
        <!-- 🎯 حالة عدم وجود أسئلة -->
        <div class="text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-300">
            <div class="text-4xl mb-3 text-gray-300">
                <i class="fas fa-question-circle"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-500 mb-2">لا توجد أسئلة بعد</h3>
            <p class="text-gray-400">استخدم الأزرار في الشريط الجانبي لإضافة أول سؤال</p>
        </div>
        @endforelse
    </div>

    <style>
    .question-card {
        animation: slideIn 0.3s ease-out;
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    </style>
</div>

<!-- 🎯 سكريبت تأكيد الحذف -->
<script>
function confirmDeleteQuestion(questionId, questionText) {
    if (confirm(`هل أنت متأكد من حذف السؤال:\n"${questionText}"`)) {
        @this.deleteQuestion(questionId);
    }
}
</script>