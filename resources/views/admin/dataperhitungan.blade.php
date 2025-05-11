<title>@yield('title', 'Data Perhitungan')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-white text-black">
    <x-app-layout>
        <div class="flex min-h-screen">
            @include('components.sidebar-admin')

            <!-- Konten dashboard lainnya di sini -->
            <main class="flex-1 p-10">
                <h1 class="text-2xl font-bold">Data Perhitungan</h1>

                
            </main>
        </div>
    </x-app-layout>
</body>