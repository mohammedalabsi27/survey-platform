<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('layouts.partials.head')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- 🎯 الهيدر الرئيسي -->
    @include('layouts.partials.header')


    <!-- 🎯 قسم الهيدر الداخلي -->
    <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">@yield('header', 'لوحة التحكم')</h2>
                    @hasSection('subheader')
                    <p class="text-gray-600 mt-1">@yield('subheader')</p>
                    @endif
                </div>
                
                <!-- أزرار إضافية -->
                <div class="flex gap-3">
                    @yield('header-actions')
                </div>
            </div>
        </div>
    </div>

    <!-- 🎯 المحتوى الرئيسي -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- 🎯 الفوتر -->
    @include('layouts.partials.footer')


    <!-- 🎯 السكريبتات -->
    @include('layouts.partials.scripts')

    @stack('scripts')
</body>
</html>