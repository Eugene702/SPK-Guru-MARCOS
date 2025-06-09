<title>@yield('title', 'Data Guru')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<body class="bg-creamy h-full" x-data>
    <x-app-layout>
        <div class="flex flex-col md:flex-row min-h-screen">
            @include('components.sidebar-admin')

            <main class="flex-1 p-6 md:p-10">
                {{-- Tambahkan class w-full dan max-w-xxxx (misalnya max-w-7xl) pada div ini --}}
                <div class="mx-auto bg-white shadow-xl rounded-xl p-6 w-full max-w-5xl">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Data Guru</h1>
                    <p class="text-gray-600 text-center mb-4">
                        Menampilkan daftar lengkap seluruh guru beserta detail informasinya.
                    </p>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {!! session('error') !!}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-400 text-white p-4 rounded-xl w-full mb-4 mt-2">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <x-admin.teacher-data.create-modal :$opsiKelas :$mataPelajarans :$attendanceFromFirstData />
                    
                    <div class="overflow-x-auto">
                        <x-admin.teacher-data.table-data :$gurus :$opsiKelas :$mataPelajarans />
                    </div>
                </div>
            </main>
        </div>
    </x-app-layout>
</body>