<div>
    <form wire:submit.prevent="login" class="space-y-4">
        <div>
            <label for="email">البريد الإلكتروني</label>
            <input id="email" type="email" wire:model="email" class="w-full border p-2 rounded">
            @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password">كلمة المرور</label>
            <input id="password" type="password" wire:model="password" class="w-full border p-2 rounded">
            @error('password') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center">
            <input id="remember" type="checkbox" wire:model="remember">
            <label for="remember" class="ml-2">تذكرني</label>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">
            تسجيل الدخول
        </button>
    </form>

    <p class="mt-4 text-center text-sm">
        ليس لديك حساب؟ <a href="{{ route('register') }}" class="text-green-600">سجل هنا</a>
    </p>
</div>
