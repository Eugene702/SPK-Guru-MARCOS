<title>@yield('title', 'Data Kriteria')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-white">
<x-app-layout>
    <div class="flex flex-col md:flex-row min-h-screen">
        @include('components.sidebar-admin')

        <main class="flex-1 p-6 md:p-10">
            <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6">
                <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Data Kriteria</h1>
                <p class="text-gray-600 text-center mb-8">Berikut adalah data kriteria yang digunakan dalam sistem penilaian.</p>

                <div class="overflow-x-auto rounded-lg border border-gray-300">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-thead text-black">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">No</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Nama Kriteria</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Bobot Kriteria</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Jenis Kriteria</th>
                                <th class="px-4 py-3 text-sm font-semibold text-center border">Cara Penilaian</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-gray-800">
                            @foreach($kriterias as $index => $kriteria)
                                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} text-center hover:bg-yellow-50 transition">
                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $kriteria->nama_kriteria }}</td>
                                    <td class="px-4 py-2 border">{{ $kriteria->bobot_kriteria }}</td>
                                    <td class="px-4 py-2 border">{{ $kriteria->jenis }}</td>
                                    <td class="px-4 py-2 border">{{ $kriteria->cara_penilaian }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <p class="text-sm text-gray-500 text-center italic mt-6">"Menilai bukan hanya membandingkan, tapi memahami nilai di balik setiap kriteria."</p>
            </div>
        </main>
    </div>
</x-app-layout>
</body>
