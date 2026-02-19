<div>
    <form wire:submit.prevent="register" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">الاسم الكامل</label>
            <input id="name" type="text" wire:model="name" placeholder="أدخل اسمك"
                class="mt-1 w-full border p-2 rounded">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
            <input id="email" type="email" wire:model="email" placeholder="example@mail.com"
                class="mt-1 w-full border p-2 rounded">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
            <input id="password" type="password" wire:model="password" placeholder="********"
                class="mt-1 w-full border p-2 rounded">
            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">تأكيد كلمة المرور</label>
            <input id="password_confirmation" type="password" wire:model="password_confirmation"
                placeholder="********" class="mt-1 w-full border p-2 rounded">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
            تسجيل
        </button>
    </form>

    <p class="mt-4 text-center text-sm">
        لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="text-blue-600 hover:underline">تسجيل الدخول</a>
    </p>

</div>
