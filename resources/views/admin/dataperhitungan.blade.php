<title>@yield('title', 'Data Perhitungan')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-creamy">
    <x-app-layout>
        <div class="flex flex-col md:flex-row min-h-screen">
            @include('components.sidebar-admin')

            <!-- Konten dashboard lainnya di sini -->
                <main class="flex-1 p-6 space-y-10 overflow-x-hidden">
                <div class="mb-10">
                    <div class="text-gray-800 text-center rounded-xl shadow-md p-6 bg-amber-400/25">
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">Proses Perhitungan MARCOS</h1>
                        <p class="text-gray-700">
                        Di bawah ini adalah tahapan-tahapan penting dalam proses pengambilan keputusan menggunakan metode <strong>MARCOS</strong>. Ikuti alur dari normalisasi hingga rangking akhir untuk mengetahui hasil evaluasi terbaik.
                        </p>
                    </div>
                </div>

                <div x-data="{ selectedYear: '{{ request('year') }}', open: false }" class="flex justify-end mb-4">
                    <div class="relative inline-block text-left">
                        <div>
                            <button @click="open = !open" type="button" class="inline-flex justify-between w-48 rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" aria-expanded="true" aria-haspopup="true">
                                <span x-text="selectedYear ? selectedYear : 'Pilih Tahun'">Pilih Tahun</span>
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                        >
                            <div class="py-1" role="none">
                                <a 
                                    href="{{ request()->url() }}"
                                    class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900" 
                                    role="menuitem"
                                >Semua Tahun</a>
                                @foreach($year as $y)
                                    <a 
                                        href="{{ request()->url() }}?year={{ $y->year }}"
                                        class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 hover:text-gray-900 {{ request('year') == $y->year ? 'bg-gray-100' : '' }}" 
                                        role="menuitem"
                                    >{{ $y->year }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md overflow-x-auto">
                    <h2 class="text-xl font-semibold text-orange-500 mb-2">1. Skor Awal Alternatif</h2>
                    <p class="text-gray-600 mb-4">Berikut adalah skor awal masing-masing guru berdasarkan kriteria yang telah ditentukan.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                @foreach (collect($scoreWeights)->keys() as $row)
                                    <th class="border px-4 py-2 capitalize">{{ str_replace('_', ' ', $row) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    @foreach ($scoreWeights as $keys => $_)
                                        <td class="border px-4 py-2">{{ $row[$keys] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md overflow-x-auto">
                    <h2 class="text-xl font-semibold text-orange-500 mb-2">2. Konversi Skor ke Linguistik</h2>
                    <p class="text-gray-600 mb-4">Skor awal dikonversi menjadi bentuk linguistik agar lebih representatif dalam proses evaluasi.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                @foreach (collect($scoreWeights)->keys() as $row)
                                    <th class="border px-4 py-2 capitalize">{{ str_replace('_', ' ', $row) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($liguistics as $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    @foreach ($scoreWeights as $keys => $_)
                                        <td class="border px-4 py-2">{{ $row[$keys] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md overflow-x-auto">
                    <h2 class="text-xl font-semibold text-orange-500 mb-2">3. Penentuan Solusi Ideal (AI) & Anti-Ideal (AAI)</h2>
                    <p class="text-gray-600 mb-4">Solusi ideal dan anti-ideal digunakan sebagai acuan pembanding terhadap seluruh alternatif.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                @foreach (collect($scoreWeights)->keys() as $row)
                                    <th class="border px-4 py-2 capitalize">{{ str_replace('_', ' ', $row) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-thead">
                                <td class="border px-4 py-2">AAI</td>
                                @foreach ($scoreWeights as $keys => $_)
                                    <td class="border px-4 py-2">{{ $idealSolution['aai'][$keys] }}</td>
                                @endforeach
                            </tr>

                            @foreach ($idealSolution['data'] as $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    @foreach ($scoreWeights as $keys => $_)
                                        <td class="border px-4 py-2">{{ $row[$keys] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr class="bg-thead">
                                <td class="border px-4 py-2">AI</td>
                                @foreach ($scoreWeights as $keys => $_)
                                    <td class="border px-4 py-2">{{ $idealSolution['ai'][$keys] }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md overflow-x-auto">
                    <h2 class="text-xl font-semibold text-orange-500 mb-2">4. Normalisasi Matriks Keputusan</h2>
                    <p class="text-gray-600 mb-4">Normalisasi dilakukan untuk menyetarakan nilai antar alternatif terhadap solusi ideal.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                @foreach (collect($scoreWeights)->keys() as $row)
                                    <th class="border px-4 py-2 capitalize">{{ str_replace('_', ' ', $row) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-thead">
                                <td class="border px-4 py-2">AAI</td>
                                @foreach ($scoreWeights as $keys => $_)
                                    <td class="border px-4 py-2">{{ $normalized['aai'][$keys] }}</td>
                                @endforeach
                            </tr>

                            @foreach ($normalized['data'] as $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    @foreach ($scoreWeights as $keys => $_)
                                        <td class="border px-4 py-2">{{ $row[$keys] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr class="bg-thead">
                                <td class="border px-4 py-2">AI</td>
                                @foreach ($scoreWeights as $keys => $_)
                                    <td class="border px-4 py-2">{{ $normalized['ai'][$keys] }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md overflow-x-auto">
                    <h2 class="text-xl font-semibold text-orange-500 mb-2">5. Matriks Tertimbang</h2>
                    <p class="text-gray-600 mb-4">Nilai normalisasi dikalikan dengan bobot kriteria untuk memperoleh nilai tertimbang.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                @foreach (collect($scoreWeights)->keys() as $row)
                                    <th class="border px-4 py-2 capitalize">{{ str_replace('_', ' ', $row) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-thead">
                                <td class="border px-4 py-2">AAI</td>
                                @foreach ($scoreWeights as $keys => $_)
                                    <td class="border px-4 py-2">{{ $weighting['aai'][$keys] }}</td>
                                @endforeach
                            </tr>

                            @foreach ($weighting['data'] as $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    @foreach ($scoreWeights as $keys => $_)
                                        <td class="border px-4 py-2">{{ $row[$keys] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr class="bg-thead">
                                <td class="border px-4 py-2">AI</td>
                                @foreach ($scoreWeights as $keys => $_)
                                    <td class="border px-4 py-2">{{ $weighting['ai'][$keys] }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md">
                     <h2 class="text-xl font-semibold text-orange-500 mb-2">6. Fungsi Utilitas</h2>
                    <p class="text-gray-600 mb-4">Perhitungan nilai utilitas berdasarkan solusi ideal dan anti-ideal.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Si</th>
                                <th class="border px-4 py-2">Ki-</th>
                                <th class="border px-4 py-2">Ki+</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-thead">
                                <td class="border px-4 py-2">AAI</td>
                                <td class="border px-4 py-2">{{ $utilityResult['aai']['si'] }}</td>
                                <td class="border px-4 py-2">-</td>
                                <td class="border px-4 py-2">-</td>
                            </tr>

                            @foreach ($utilityResult['data'] as $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    <td class="border px-4 py-2">{{ $row['si'] }}</td>
                                    <td class="border px-4 py-2">{{ $row['kiMinus'] }}</td>
                                    <td class="border px-4 py-2">{{ $row['kiPlus'] }}</td>
                                </tr>
                            @endforeach

                            <tr class="bg-thead">
                                <td class="border px-4 py-2">AAI</td>
                                <td class="border px-4 py-2">{{ $utilityResult['ai']['si'] }}</td>
                                <td class="border px-4 py-2">-</td>
                                <td class="border px-4 py-2">-</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md">
                   <h2 class="text-xl font-semibold text-orange-500 mb-2">7. Skor Akhir Alternatif</h2>
                    <p class="text-gray-600 mb-4">Nilai akhir diperoleh berdasarkan kombinasi dari fungsi utilitas terhadap solusi ideal dan anti-ideal.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Fk-</th>
                                <th class="border px-4 py-2">Fk+</th>
                                <th class="border px-4 py-2">Fk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($utilityFinal as $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    <td class="border px-4 py-2">{{ $row['fkMinus'] }}</td>
                                    <td class="border px-4 py-2">{{ $row['fkPlus'] }}</td>
                                    <td class="border px-4 py-2">{{ $row['fk'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md">
                     <h2 class="text-xl font-semibold text-orange-500 mb-2">8. Rangking Akhir</h2>
                    <p class="text-gray-600 mb-4">Berikut adalah hasil akhir pemeringkatan dari alternatif terbaik berdasarkan nilai Fk.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Fk</th>
                                <th class="border px-4 py-2">Rangking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ranking as $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    <td class="border px-4 py-2">{{ $row['fk'] }}</td>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
    </x-app-layout>
</body>
