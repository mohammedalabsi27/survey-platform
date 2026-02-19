<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('layouts.partials.head')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- 🎯 الهيدر الرئيسي -->
    @include('layouts.partials.header')

    <!-- 🎯 المحتوى الرئيسي -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- 🎯 الفوتر -->
    @include('layouts.partials.footer')

    <!-- 🎯 السكريبتات -->
    @include('layouts.partials.scripts')

    @stack('scripts')
</body>
</html>