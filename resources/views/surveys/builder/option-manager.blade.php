<div>
    <div class="flex justify-between items-center mb-3">
        <h5 class="font-medium text-gray-700">خيارات السؤال:</h5>
        <button wire:click="addOption"
                class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm flex items-center gap-1">
            <i class="fas fa-plus"></i>
            إضافة خيار
        </button>
    </div>
    
    <div class="space-y-2">
        @forelse($options as $option)
        <div class="flex items-center gap-2 p-2 bg-gray-50 rounded border border-gray-200 group">
            <div class="text-gray-500">
                @if($question->type == 'choice')
                <i class="fas fa-dot-circle"></i>
                @else
                <i class="fas fa-check-square"></i>
                @endif
            </div>
            <input type="text" 
                   value="{{ $option->option_text }}"
                   class="flex-1 bg-transparent border-none focus:ring-0 px-2 py-1 text-gray-700"
                   wire:blur="updateOption({{ $option->id }}, $event.target.value)">
            <button wire:click="removeOption({{ $option->id }})"
                    class="text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity">
                <i class="fas fa-trash text-sm"></i>
            </button>
        </div>
        @empty
        <div class="text-center py-3 text-gray-500 bg-gray-100 rounded-lg">
            <p class="text-sm">لا توجد خيارات بعد. أضف خيارات للمستخدمين.</p>
        </div>
        @endforelse
    </div>
</div>