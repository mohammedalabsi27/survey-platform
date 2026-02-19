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

        <!-- شريط التقدم -->
        <div class="w-full bg-gray-200 rounded-full h-2">
            @php
                $progress = $questions->count() > 0 ? min(100, ($questions->count() / 10) * 100) : 0;
            @endphp
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500" 
                 style="width: {{ $progress }}%"></div>
        </div>
        <p class="text-xs text-gray-500 mt-2 text-left">اكتمال الاستبيان: {{ round($progress) }}%</p>
    </div>

    <!-- 🎯 قائمة الأسئلة -->
    <div class="space-y-4">
        @forelse($questions as $question)
        <div class="bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 question-card"
             wire:key="question-{{ $question->id }}">
            
            <!-- رأس السؤال -->
            <div class="p-4 border-b border-gray-100">
                <div class="flex justify-between items-start">
                    <div class="flex items-start gap-3 flex-1">
                        <!-- رقم السؤال -->
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white text-sm font-bold">
                            {{ $loop->iteration }}
                        </div>
                        
                        <!-- محتوى السؤال -->
                        <div class="flex-1">
                            @if($editingQuestionId == $question->id)
                            <!-- وضع التعديل -->
                            <div class="space-y-3">
                                <textarea wire:model="editedText" 
                                          rows="2"
                                          class="w-full px-3 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="اكتب نص السؤال..."
                                          autofocus></textarea>
                                <div class="flex gap-2">
                                    <button wire:click="saveEditing"
                                            class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm flex items-center gap-1">
                                        <i class="fas fa-save"></i>
                                        حفظ
                                    </button>
                                    <button wire:click="cancelEditing"
                                            class="px-3 py-1 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm flex items-center gap-1">
                                        <i class="fas fa-times"></i>
                                        إلغاء
                                    </button>
                                </div>
                            </div>
                            @else
                            <!-- وضع العرض -->
                            <h4 class="font-semibold text-gray-800 mb-1">{{ $question->question_text }}</h4>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <span class="bg-gray-100 px-2 py-1 rounded">
                                    <i class="fas fa-tag ml-1"></i>
                                    {{ $this->getTypeArabic($question->type) }}
                                </span>
                                <span class="text-gray-400">
                                    {{ $question->created_at->diffForHumans() }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- 🎯 أزرار التحكم -->
                    @if($editingQuestionId != $question->id)
                    <div class="flex gap-2">
                        <!-- زر التعديل -->
                        <button wire:click="startEditing({{ $question->id }})"
                                class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm flex items-center gap-1 transition-colors">
                            <i class="fas fa-edit text-xs"></i>
                            تعديل
                        </button>
                        
                        <!-- زر الحذف -->
                        <button onclick="confirmDeleteQuestion({{ $question->id }}, '{{ addslashes($question->question_text) }}')"
                                class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm flex items-center gap-1 transition-colors">
                            <i class="fas fa-trash text-xs"></i>
                            حذف
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 🎯 معاينة السؤال -->
            <div class="p-4">
                @include('surveys.partials.question-types', ['question' => $question])

                <!-- 🎯 OptionManager منفصل للأسئلة الاختيارية -->
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


<!-- 🎯 ستايلات -->
<style>
.question-card {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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

