<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'منصة الاستبيانات')</title>

    @if(app()->environment('local'))
        <script src="https://cdn.tailwindcss.com"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    
    @stack('styles')
    
    <style>
        body { font-family: 'Tajawal', sans-serif; } /* [cite: 1506] */
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); } /* [cite: 1507, 1508] */
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); } /* [cite: 1509-1511] */
        /* ... باقي الـ Custom CSS مثل tooltip و scrollbar ... */
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    
    @include('layouts.navigation')

    <main class="container mx-auto px-4 py-8">
        @if(session()->has('success'))
            {{-- هنا يمكنك استدعاء مكون إشعار (Notification Component) --}}
            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
    
    <footer class="bg-gray-800 text-white mt-16">
        <div class="container mx-auto px-4 py-8">
            {{-- يمكنك هنا تضمين الفوتر في ملف منفصل أيضاً: @include('layouts.footer') --}}
            @include('layouts.footer')
        </div>
        <div class="border-t border-gray-700 py-4 text-center text-gray-400 text-sm">
             <p>© 2024 استبياني. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    
    @stack('scripts')
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- [cite: 1505] --}}
    {{-- هنا مكان الـ Scripts التي كانت في الـ Master --}}

</body>
</html>