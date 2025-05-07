<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white text-black">
    <div class="flex h-screen">
        @include('components.sidebar')

        <main class="flex-1 p-10">
            <h1 class="text-2xl font-bold">Data Penilaian oleh Rekan Sejawat</h1>
            <!-- Konten dashboard lainnya di sini -->

        </main>
    </div>
</body>
</html>