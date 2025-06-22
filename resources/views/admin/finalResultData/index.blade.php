<title>@yield('title', 'Data Hasil Akhir')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body>
    <x-app-layout>
        <div class="flex min-h-screen">
            @include('components.sidebar-admin')

            <main class="flex-1 p-10 min-h-screen">
                <div class="max-w-6xl mx-auto bg-white shadow-xl rounded-xl p-8">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">🏆 Hasil Perangkingan Alternatif Terbaik</h1>
                    <p class="text-center text-gray-700 italic mb-6">
                        Berikut adalah daftar peringkat berdasarkan hasil evaluasi akhir.
                    </p>

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.final-result-data.print') }}"
                            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="fill-white w-4 h-4">
                                <path d="M128 0C92.7 0 64 28.7 64 64l0 96 64 0 0-96 226.7 0L384 93.3l0 66.7 64 0 0-66.7c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0L128 0zM384 352l0 32 0 64-256 0 0-64 0-16 0-16 256 0zm64 32l32 0c17.7 0 32-14.3 32-32l0-96c0-35.3-28.7-64-64-64L64 192c-35.3 0-64 28.7-64 64l0 96c0 17.7 14.3 32 32 32l32 0 0 64c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-64zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                            </svg>
                            <span>Cetak</span>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-300 text-center rounded-lg overflow-hidden">
                            <thead class="bg-[#FFB343] text-white">
                                <tr>
                                    <th class="px-6 py-3 border border-orange-300">Peringkat</th>
                                    <th class="px-6 py-3 border border-orange-300">Nama Alternatif</th>
                                    <th class="px-6 py-3 border border-orange-300">Nilai Akhir</th>
                                    <th class="px-6 py-3 border border-orange-300">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800">
                                @foreach ($ranking as $index => $row)
                                    <tr class="{{ $loop->first ? 'bg-yellow-100 font-semibold' : 'hover:bg-creamy' }}">
                                        <td class="px-6 py-3 border">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-3 border">{{ $row['nama'] }}</td>
                                        <td class="px-6 py-3 border">{{ number_format($row['fk'], 4) }}</td>
                                        <td class="px-6 py-3 border">
                                            @if ($loop->first)
                                                <span class="bg-green-600 text-white text-sm px-3 py-1 rounded-full">Terbaik</span>
                                            @else
                                                <span class="text-gray-500">–</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <p class="text-center text-sm text-gray-600 italic mt-6">
                        “Prestasi bukanlah kebetulan, melainkan hasil dari kerja keras, ketekunan, dan dedikasi yang konsisten.”
                    </p>
                </div>
            </main>
        </div>
    </x-app-layout>
</body>