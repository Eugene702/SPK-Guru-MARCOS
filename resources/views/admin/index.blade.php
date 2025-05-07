<!-- Tambahkan di bagian <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<x-app-layout>

    <body class="text-black bg-creamy" >
        <div class="flex h-screen">
            @include('components.sidebar-admin')
            <main class="flex-1 p-10">
                {{-- <h1 class="text-2xl font-bold">Dashboard</h1><br> --}}
                <h1 class="text-2xl font-bold">Selamat Datang [nama]</h1>


<div class="max-w-6xl mx-auto px-4 py-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2 justify-center">
        <i class="fas fa-list-alt text-blue-600"></i>
        Langkah-Langkah Melakukan Penilaian
        <i class="fas fa-list-alt text-blue-600"></i>
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card 1 -->
        <div class="transition-colors duration-300 p-4 rounded-xl shadow-md bg-white hover:bg-blue-100">
            <div class="flex items-center mb-2 text-blue-600">
                <i class="fas fa-database text-xl mr-2"></i>
                <h3 class="font-bold text-lg">Langkah 1</h3>
            </div>
            <p class="text-gray-700">Buka menu <strong>Data Penilaian</strong>.</p>
        </div>

        <!-- Card 2 -->
        <div class="transition-colors duration-300 p-4 rounded-xl shadow-md bg-white hover:bg-green-100">
            <div class="flex items-center mb-2 text-green-600">
                <i class="fas fa-pen-alt text-xl mr-2"></i>
                <h3 class="font-bold text-lg">Langkah 2</h3>
            </div>
            <p class="text-gray-700">Klik tombol <strong>Nilai</strong> di baris yang ingin dinilai.</p>
        </div>

        <!-- Card 3 -->
        <div class="transition-colors duration-300 p-4 rounded-xl shadow-md bg-white hover:bg-yellow-100">
            <div class="flex items-center mb-2 text-yellow-500">
                <i class="fas fa-keyboard text-xl mr-2"></i>
                <h3 class="font-bold text-lg">Langkah 3</h3>
            </div>
            <p class="text-gray-700">Isi data sesuai kolom yang tersedia.</p>
        </div>

        <!-- Card 4 -->
        <div class="transition-colors duration-300 p-4 rounded-xl shadow-md bg-white hover:bg-indigo-100">
            <div class="flex items-center mb-2 text-indigo-600">
                <i class="fas fa-save text-xl mr-2"></i>
                <h3 class="font-bold text-lg">Langkah 4</h3>
            </div>
            <p class="text-gray-700">Kalau sudah lengkap, klik tombol <strong>Simpan</strong>.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Card 5 -->
        <div class="transition-colors duration-300 p-4 rounded-xl shadow-md bg-white hover:bg-pink-100">
            <div class="flex items-center mb-2 text-pink-500">
                <i class="fas fa-edit text-xl mr-2"></i>
                <h3 class="font-bold text-lg">Langkah 5</h3>
            </div>
            <p class="text-gray-700">Kalau mau mengubah data, klik tombol <strong>Edit</strong>.</p>
        </div>

        <!-- Card 6 -->
        <div class="transition-colors duration-300 p-4 rounded-xl shadow-md bg-white hover:bg-red-100">
            <div class="flex items-center mb-2 text-red-500">
                <i class="fas fa-sync-alt text-xl mr-2"></i>
                <h3 class="font-bold text-lg">Langkah 6</h3>
            </div>
            <p class="text-gray-700">Lakukan perubahan, lalu klik <strong>Simpan Perubahan</strong>.</p>
        </div>

        <!-- Card 7 -->
        <div class="transition-colors duration-300 p-4 rounded-xl shadow-md bg-white hover:bg-emerald-100">
            <div class="flex items-center mb-2 text-emerald-600">
                <i class="fas fa-check-circle text-xl mr-2"></i>
                <h3 class="font-bold text-lg">Langkah 7</h3>
            </div>
            <p class="text-gray-700"><strong>Selesai!</strong> Penilaian sudah berhasil disimpan 🎉</p>
        </div>
    </div>
</div>


            </main>
        </div>
    </body>

</x-app-layout>