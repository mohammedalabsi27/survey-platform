@if($question->type == 'text')
<div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
    <p class="text-blue-700 text-sm">المستخدم سيدخل إجابة نصية قصيرة</p>
</div>

@elseif($question->type == 'textarea')
<div class="p-3 bg-green-50 rounded-lg border border-green-200">
    <p class="text-green-700 text-sm">المستخدم سيدخل إجابة نصية مفصلة</p>
</div>

@elseif($question->type == 'choice')
<div class="space-y-2">
    @foreach($question->options as $option)
    <div class="flex items-center gap-2 p-2 bg-yellow-50 rounded border border-yellow-200">
        <div class="text-yellow-600">
            <i class="fas fa-dot-circle"></i>
        </div>
        <span class="text-gray-700">{{ $option->option_text }}</span>
    </div>
    @endforeach
</div>

@elseif($question->type == 'multiple_choice')
<div class="space-y-2">
    @foreach($question->options as $option)
    <div class="flex items-center gap-2 p-2 bg-purple-50 rounded border border-purple-200">
        <div class="text-purple-600">
            <i class="fas fa-check-square"></i>
        </div>
        <span class="text-gray-700">{{ $option->option_text }}</span>
    </div>
    @endforeach
</div>

@elseif($question->type == 'yes_no')
<div class="grid grid-cols-2 gap-3">
    <div class="bg-green-100 p-3 rounded-lg text-center">
        <div class="text-lg">👍</div>
        <span class="text-green-800 font-semibold">نعم</span>
    </div>
    <div class="bg-red-100 p-3 rounded-lg text-center">
        <div class="text-lg">👎</div>
        <span class="text-red-800 font-semibold">لا</span>
    </div>
</div>

@elseif($question->type == 'rating')
<div class="flex justify-center gap-1">
    @foreach([1,2,3,4,5] as $star)
    <div class="text-2xl text-yellow-400">
        <i class="fas fa-star"></i>
    </div>
    @endforeach
</div>
@endif