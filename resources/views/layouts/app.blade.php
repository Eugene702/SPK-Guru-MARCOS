<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-creamy">
    <div class="min-h-screen">
        @include('sweetalert2::index')
        @include('layouts.navigation')
        <main>
            {{ $slot }}
        </main>

        <div x-data="scrollToTop()" x-init="init()" x-cloak>
            <button @click="scrollToTop" x-show="showButton" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-4"
                class="fixed bottom-8 right-8 p-0 w-14 h-14 flex items-center justify-center bg-amber-200 hover:bg-amber-300 text-amber-800 border-4 border-white rounded-full shadow-xl z-50 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 group"
                style="background-color: #ffd480; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05), 0 0 0 6px rgba(255, 212, 128, 0.2);"
                aria-label="Scroll to top">
                <span
                    class="absolute -top-10 -left-3 transform scale-0 transition-transform duration-300 ease-in-out origin-bottom group-hover:scale-100">
                    <span class="block bg-gray-800 text-white text-xs px-3 py-1 rounded-lg">Ke Atas</span>
                    <span class="block w-3 h-3 bg-gray-800 transform rotate-45 ml-5 -mt-1.5"></span>
                </span>
                <i class="fas fa-chevron-up text-lg group-hover:animate-bounce"></i>
            </button>
        </div>
    </div>

    <script>
        function scrollToTop() {
            return {
                showButton: false,
                init() {
                    const scrollThreshold = 10;
                    window.addEventListener('scroll', () => {
                        this.showButton = window.pageYOffset > scrollThreshold;
                    });

                    this.showButton = window.pageYOffset > scrollThreshold;
                },
                scrollToTop() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            };
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</body>

</html>
