<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HoneyBee Market - Buy & Sell Products and Services Near You. India's trusted marketplace for electronics, vehicles, property, fashion, and more.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HoneyBee Market - Buy & Sell Anything Near You')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen flex flex-col antialiased">

    {{-- Navigation --}}
    @include('components.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
    <div id="flash-success" class="fixed top-20 right-4 left-4 z-50 rounded-xl bg-amber-500/90 px-4 py-3 font-medium text-gray-900 shadow-2xl backdrop-blur-sm animate-slide-in-right sm:left-auto sm:max-w-md sm:px-6">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if($errors->any())
    <div id="flash-error" class="fixed top-20 right-4 left-4 z-50 rounded-xl bg-red-500/90 px-4 py-3 font-medium text-white shadow-2xl backdrop-blur-sm animate-slide-in-right sm:left-auto sm:max-w-md sm:px-6">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    @stack('scripts')

    <script>
        // Auto-hide flash messages
        setTimeout(() => {
            document.querySelectorAll('#flash-success, #flash-error').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateX(100%)';
                setTimeout(() => el.remove(), 300);
            });
        }, 4000);
    </script>
</body>
</html>
