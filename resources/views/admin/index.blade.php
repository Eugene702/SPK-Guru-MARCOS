<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<x-app-layout>

    <body class="text-black bg-creamy">
        <div class="flex h-screen">
            @include('components.sidebar-admin')
            <main class="flex-1 p-10">
                <h1 class="text-2xl font-bold">Selamat Datang {{ auth()->user()->name }}</h1>
                <x-steps-conducting-assessment />
            </main>
        </div>
    </body>

</x-app-layout>
