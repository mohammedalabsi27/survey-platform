<div class="max-w-4xl mx-auto px-4">
    <!-- 🎯 رسائل التنبيه -->
    @if(session()->has('error'))
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-4 animate-fade-in">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                <i class="fas fa-exclamation-triangle text-lg"></i>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-red-800 text-base mb-1">خطأ في الإرسال</h4>
                <p class="text-red-700 text-sm">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" 
                    class="text-red-600 hover:text-red-800 p-1 rounded-lg hover:bg-red-100 transition-colors">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session()->has('success'))
    <div class="bg-green-50 border border-green-200 rounded-2xl p-4 mb-4 animate-fade-in">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                <i class="fas fa-check-circle text-lg"></i>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-green-800 text-base mb-1">تم بنجاح!</h4>
                <p class="text-green-700 text-sm">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- 1️⃣ إذا كان الاستبيان مغلقاً (يدوياً (مسودة) أو بسبب الوقت) -->
    @if($isClosed)
    <div class="text-center py-16 bg-white rounded-2xl shadow-lg border border-gray-200 animate-fade-in">
        <div class="max-w-md mx-auto px-4">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 text-4xl mx-auto mb-6">
                <!-- 💡 عرض الأيقونة الديناميكية -->
                <i class="fas {{ $closedIcon }}"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">عذراً، الاستبيان مغلق</h2>
            <!-- 💡 عرض الرسالة الديناميكية -->
            <p class="text-gray-600 text-base mb-8 leading-relaxed font-medium">
                {{ $closedMessage }}
            </p>
            <a href="{{ url('/') }}" class="bg-gray-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-900 transition-colors shadow flex items-center justify-center gap-2 w-full sm:w-auto mx-auto inline-flex">
                <i class="fas fa-home"></i> العودة للصفحة الرئيسية
            </a>
        </div>
    </div>

    <!-- 2️⃣ 💡 إذا كان المستخدم قد شارك مسبقاً -->
    @elseif($alreadySubmitted)
    <div class="text-center py-16 bg-white rounded-2xl shadow-lg border border-gray-200 animate-fade-in">
        <div class="max-w-md mx-auto px-4">
            <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center text-{{ $survey->theme_color ?? 'blue' }}-500 text-4xl mx-auto mb-6">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">لقد قمت بالمشاركة مسبقاً!</h2>
            <p class="text-gray-600 text-base mb-8 leading-relaxed">
                شكراً لاهتمامك، ولكن نظامنا يوضح أنك قمت بتعبئة هذا الاستبيان بالفعل. للحفاظ على دقة النتائج، لا يمكن إرسال أكثر من رد واحد.
            </p>
            <a href="{{ url('/') }}" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors shadow flex items-center justify-center gap-2 w-full sm:w-auto mx-auto inline-flex">
                <i class="fas fa-home"></i> العودة للرئيسية
            </a>
        </div>
    </div>

    <!-- 3️⃣ بعد الإرسال الناجح -->
    @elseif($isSubmitted)
    <div class="text-center py-12 bg-white rounded-2xl shadow-lg border border-gray-200 animate-fade-in">
        <div class="max-w-md mx-auto px-4">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white text-3xl mx-auto mb-4 animate-bounce">
                <i class="fas fa-check"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-3">شكراً لك على المشاركة! 🎉</h2>
            <p class="text-gray-600 text-base mb-6 leading-relaxed">
                {{ $survey->thank_you_message ?? 'إجاباتك تم حفظها بنجاح وسيتم تحليلها قريباً.' }}
                <br>
                <span class="text-green-600 font-semibold">مساهمتك تساعد في تحسين الخدمات</span>
            </p>
            <div class="flex justify-center">
                <a href="{{ url('/') }}" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors shadow flex items-center justify-center gap-2 group text-sm">
                    <i class="fas fa-home group-hover:scale-110 transition-transform"></i>
                    العودة للرئيسية
                </a>
                <!-- 💡 تم حذف زر (تعبئة الاستبيان مرة أخرى) لأنه لم يعد مسموحاً -->
            </div>
        </div>
    </div>

    <!-- 4️⃣ عرض نموذج الاستبيان إذا كانت كل الشروط السابقة غير متحققة -->
    @else
    <!-- 🎯 نموذج الاستبيان -->
    <form wire:submit="submitSurvey" class="space-y-4">
        @foreach($survey->questions as $index => $question)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 question-card group"
             wire:key="question-{{ $question->id }}"
             x-data="{ isFocused: false }"
             @focusin="isFocused = true"
             @focusout="isFocused = false">
            
            <!-- رأس السؤال -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-start gap-3">
                    <!-- رقم السؤال -->
                    <div class="w-10 h-10 bg-gradient-to-br from-{{ $survey->theme_color ?? 'blue' }}-500 to-{{ $survey->theme_color ?? 'blue' }}-600 rounded-xl flex items-center justify-center text-white font-bold text-base flex-shrink-0">
                        {{ $index + 1 }}
                    </div>
                    
                    <!-- نص السؤال -->
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 leading-relaxed">
                            {{ $question->question_text }}
                            @if($question->required)
                            <span class="text-red-500 text-sm align-super">*</span>
                            @endif
                        </h3>
                        
                        <!-- نوع السؤال -->
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="bg-gray-100 px-2 py-0.5 rounded-lg">
                                <i class="fas fa-tag ml-1"></i>
                                {{ $this->getTypeArabic($question->type) }}
                            </span>
                            @if($question->required)
                            <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded-lg">
                                <i class="fas fa-asterisk ml-1"></i>
                                إجباري
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🎯 جسم السؤال - أنواع الإجابة -->
            <div class="p-6">
                @if($question->type == 'text')
                <!-- 📝 نص قصير -->
                <input type="text" 
                       wire:model="answers.{{ $question->id }}"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-{{ $survey->theme_color ?? 'blue' }}-500 focus:border-{{ $survey->theme_color ?? 'blue' }}-500 transition-all duration-200 bg-gray-50 placeholder-gray-400 text-base"
                       placeholder="اكتب إجابتك هنا..."
                       x-bind:class="{ 'border-{{ $survey->theme_color ?? 'blue' }}-500 bg-blue-50': isFocused }">

                @elseif($question->type == 'textarea')
                <!-- 📝 نص طويل -->
                <textarea rows="4"
                          wire:model="answers.{{ $question->id }}"
                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-{{ $survey->theme_color ?? 'blue' }}-500 focus:border-{{ $survey->theme_color ?? 'blue' }}-500 transition-all duration-200 bg-gray-50 placeholder-gray-400 resize-none text-base"
                          placeholder="اكتب إجابتك المفصلة هنا..."
                          x-bind:class="{ 'border-{{ $survey->theme_color ?? 'blue' }}-500 bg-blue-50': isFocused }"></textarea>

                @elseif($question->type == 'choice')
                <!-- 🔘 اختيار وحيد -->
                <div class="space-y-3">
                    @foreach($question->options as $option)
                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 cursor-pointer transition-all duration-200 group/choice"
                           x-bind:class="{ 'border-{{ $survey->theme_color ?? 'blue' }}-500 bg-blue-50': $wire.answers[{{ $question->id }}] === '{{ $option->option_text }}' }">
                        <input type="radio" 
                               wire:model="answers.{{ $question->id }}"
                               value="{{ $option->option_text }}"
                               class="text-blue-600 focus:ring-{{ $survey->theme_color ?? 'blue' }}-500 scale-110 ml-3">
                        <span class="text-gray-700 text-base font-medium flex-1 group-hover/choice:text-blue-700 transition-colors">
                            {{ $option->option_text }}
                        </span>
                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center group-hover/choice:border-blue-400 transition-colors"
                             x-bind:class="{ 'border-{{ $survey->theme_color ?? 'blue' }}-500 bg-{{ $survey->theme_color ?? 'blue' }}-500': $wire.answers[{{ $question->id }}] === '{{ $option->option_text }}' }">
                            <i class="fas fa-check text-white text-xs" 
                               x-show="$wire.answers[{{ $question->id }}] === '{{ $option->option_text }}'"></i>
                        </div>
                    </label>
                    @endforeach
                </div>

                @elseif($question->type == 'multiple_choice')
                <!-- ☑️ اختيار متعدد -->
                <div class="space-y-3">
                    @foreach($question->options as $option)
                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl hover:border-purple-300 hover:bg-purple-50 cursor-pointer transition-all duration-200 group/choice"
                           x-bind:class="{ 'border-purple-500 bg-purple-50': Array.isArray($wire.answers[{{ $question->id }}]) && $wire.answers[{{ $question->id }}].includes('{{ $option->option_text }}') }">
                        <input type="checkbox" 
                               wire:model="answers.{{ $question->id }}"
                               value="{{ $option->option_text }}"
                               class="text-purple-600 focus:ring-purple-500 scale-110 ml-3 rounded">
                        <span class="text-gray-700 text-base font-medium flex-1 group-hover/choice:text-purple-700 transition-colors">
                            {{ $option->option_text }}
                        </span>
                        <div class="w-6 h-6 border-2 border-gray-300 rounded-lg flex items-center justify-center group-hover/choice:border-purple-400 transition-colors"
                             x-bind:class="{ 'border-purple-500 bg-purple-500': Array.isArray($wire.answers[{{ $question->id }}]) && $wire.answers[{{ $question->id }}].includes('{{ $option->option_text }}') }">
                            <i class="fas fa-check text-white text-xs" 
                               x-show="Array.isArray($wire.answers[{{ $question->id }}]) && $wire.answers[{{ $question->id }}].includes('{{ $option->option_text }}')"></i>
                        </div>
                    </label>
                    @endforeach
                </div>

                @elseif($question->type == 'yes_no')
                <!-- 👍👎 نعم/لا -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center justify-center p-6 border-2 border-gray-200 rounded-2xl hover:border-green-400 hover:bg-green-50 cursor-pointer transition-all duration-200 group/choice flex-col"
                           x-bind:class="{ 'border-green-500 bg-green-50': $wire.answers[{{ $question->id }}] === 'نعم' }">
                        <input type="radio" 
                               wire:model="answers.{{ $question->id }}"
                               value="نعم"
                               class="hidden">
                        <div class="text-3xl mb-2 text-gray-400 group-hover/choice:text-green-500 transition-colors"
                             x-bind:class="{ 'text-green-500': $wire.answers[{{ $question->id }}] === 'نعم' }">
                            <i class="fas fa-thumbs-up"></i>
                        </div>
                        <span class="text-base font-semibold text-gray-700 group-hover/choice:text-green-700 transition-colors">نعم</span>
                    </label>
                    
                    <label class="flex items-center justify-center p-6 border-2 border-gray-200 rounded-2xl hover:border-red-400 hover:bg-red-50 cursor-pointer transition-all duration-200 group/choice flex-col"
                           x-bind:class="{ 'border-red-500 bg-red-50': $wire.answers[{{ $question->id }}] === 'لا' }">
                        <input type="radio" 
                               wire:model="answers.{{ $question->id }}"
                               value="لا"
                               class="hidden">
                        <div class="text-3xl mb-2 text-gray-400 group-hover/choice:text-red-500 transition-colors"
                             x-bind:class="{ 'text-red-500': $wire.answers[{{ $question->id }}] === 'لا' }">
                            <i class="fas fa-thumbs-down"></i>
                        </div>
                        <span class="text-base font-semibold text-gray-700 group-hover/choice:text-red-700 transition-colors">لا</span>
                    </label>
                </div>

                @elseif($question->type == 'rating')
                <!-- ⭐ تقييم -->
                <div class="text-center">
                    <div class="flex justify-center gap-1.5 mb-3">
                        @foreach([1,2,3,4,5] as $star)
                        <label class="cursor-pointer transform hover:scale-105 transition-transform duration-200">
                            <input type="radio" 
                                   wire:model="answers.{{ $question->id }}"
                                   value="{{ $star }}"
                                   class="hidden">
                            <div class="text-3xl transition duration-200"
                                 x-bind:class="$wire.answers[{{ $question->id }}] >= {{ $star }} ? 'text-yellow-500' : 'text-gray-300 hover:text-yellow-400'">
                                <i class="fas fa-star"></i>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <div class="flex justify-between text-gray-500 text-xs px-2">
                        <span>سيء</span>
                        <span>ممتاز</span>
                    </div>
                </div>
                @endif

                <!-- رسالة خطأ إذا السؤال مطلوب -->
                @error('answers.' . $question->id)
                <div class="flex items-center gap-2 mt-3 p-3 bg-red-50 border border-red-200 rounded-xl text-sm">
                    <i class="fas fa-exclamation-circle text-red-600"></i>
                    <span class="text-red-700 font-medium">{{ $message }}</span>
                </div>
                @enderror
            </div>
        </div>
        @endforeach

        <!-- 🎯 زر الإرسال -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 text-center sticky bottom-4">
            <div class="max-w-2xl mx-auto">
                <button type="submit"
                        class="bg-gradient-to-r from-{{ $survey->theme_color ?? 'blue' }}-500 to-{{ $survey->theme_color ?? 'blue' }}-600 text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-300 shadow hover:shadow-lg w-full flex items-center justify-center gap-2 group"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed">
                    <span wire:loading.remove wire:target="submitSurvey">
                        <i class="fas fa-paper-plane group-hover:scale-110 transition-transform"></i>
                        إرسال الإجابات
                    </span>
                    <span wire:loading wire:target="submitSurvey">
                        <i class="fas fa-spinner fa-spin"></i>
                        جاري الإرسال...
                    </span>
                </button>
                
                <p class="text-gray-500 text-xs mt-2 flex items-center justify-center gap-1">
                    <i class="fas fa-info-circle"></i>
                    * الإشارة تعني أن السؤال مطلوب
                </p>

                <!-- شريط تقدم الأسئلة -->
                <div class="mt-4">
                    <div class="flex justify-between items-center text-xs text-gray-600 mb-1">
                        <span>أسئلة مكتملة: {{ $this->getCompletedQuestionsCount() }}/{{ count($survey->questions) }}</span>
                        <span>{{ round(($this->getCompletedQuestionsCount() / count($survey->questions)) * 100) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-green-500 h-1.5 rounded-full transition-all duration-500" 
                             style="width: {{ ($this->getCompletedQuestionsCount() / count($survey->questions)) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif


<!-- 🎯 الستايل المخصص -->
<style>
.animate-fade-in {
    animation: fadeIn 0.6s ease-in-out;
}

.question-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.question-card:hover {
    transform: translateY(-2px);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* تأثيرات التمرير للأسئلة */
.question-card {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
}

.question-card.in-view {
    opacity: 1;
    transform: translateY(0);
}
</style>
</div>
<!-- 🎯 السكريبتات -->
<script>
// تأثيرات الظهور عند التمرير
document.addEventListener('DOMContentLoaded', function() {
    const questionCards = document.querySelectorAll('.question-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
            }
        });
    }, { threshold: 0.1 });

    questionCards.forEach(card => {
        observer.observe(card);
    });
});

// تحديث شريط التقدم
Livewire.on('answerUpdated', () => {
    // سيتم تحديث شريط التقدم تلقائياً عبر Livewire
});

// منع إغلاق الصفحة إذا فيه إجابات غير محفوظة
window.addEventListener('beforeunload', function (e) {
    const completedQuestions = {{ $this->getCompletedQuestionsCount() }};
    if (completedQuestions > 0) {
        e.preventDefault();
        e.returnValue = 'لديك إجابات غير محفوظة. هل تريد حقاً مغادرة الصفحة؟';
    }
});
</script>
