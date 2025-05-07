<title>@yield('title', 'Dashboard')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="text-black bg-creamy" >
    <x-app-layout>
    <div class="flex h-screen">
        @include('components.sidebar-siswa')
        <main class="flex-1 p-10">
            <h1 class="text-2xl font-bold">Dashboard</h1>
        </main>
    </div>
    </x-app-layout>
</body>