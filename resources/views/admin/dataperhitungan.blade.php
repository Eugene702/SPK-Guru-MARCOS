<title>@yield('title', 'Data Perhitungan')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-creamy">
    <x-app-layout>
        <div class="flex flex-col md:flex-row min-h-screen">
            @include('components.sidebar-admin')

            <!-- Konten dashboard lainnya di sini -->
            <main class="flex-1 p-6 space-y-10">
                <div class="mb-10">
                    <div class="text-gray-800 text-center rounded-xl shadow-md p-6 bg-amber-400/25">
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">Proses Perhitungan MARCOS</h1>
                        <p class="text-gray-700">
                        Di bawah ini adalah tahapan-tahapan penting dalam proses pengambilan keputusan menggunakan metode <strong>MARCOS</strong>. Ikuti alur dari normalisasi hingga rangking akhir untuk mengetahui hasil evaluasi terbaik.
                        </p>
                    </div>
                </div>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold text-orange-500 mb-2">1. Skor Awal Alternatif</h2>
                    <p class="text-gray-600 mb-4">Berikut adalah skor awal masing-masing guru berdasarkan kriteria yang telah ditentukan.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                @foreach (collect($scoreWeights)->keys() as $row)
                                    <th class="border px-4 py-2 capitalize">{{ str_replace("_", " ", $row) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama']  }}</td>
                                    @foreach ($scoreWeights as $keys => $_)
                                        <td class="border px-4 py-2">{{ $row[$keys] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold text-orange-500 mb-2">2. Konversi Skor ke Linguistik</h2>
                    <p class="text-gray-600 mb-4">Skor awal dikonversi menjadi bentuk linguistik agar lebih representatif dalam proses evaluasi.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                @foreach (collect($scoreWeights)->keys() as $row)
                                    <th class="border px-4 py-2 capitalize">{{ str_replace("_", " ", $row) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($liguistics as $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama']  }}</td>
                                    @foreach ($scoreWeights as $keys => $_)
                                        <td class="border px-4 py-2">{{ $row[$keys] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold text-orange-500 mb-2">3. Penentuan Solusi Ideal (AI) & Anti-Ideal (AAI)</h2>
                    <p class="text-gray-600 mb-4">Solusi ideal dan anti-ideal digunakan sebagai acuan pembanding terhadap seluruh alternatif.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                @foreach (collect($scoreWeights)->keys() as $row)
                                    <th class="border px-4 py-2 capitalize">{{ str_replace("_", " ", $row) }}</th>
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
                                    <td class="border px-4 py-2">{{ $row['nama']  }}</td>
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

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold text-orange-500 mb-2">4. Normalisasi Matriks Keputusan</h2>
                    <p class="text-gray-600 mb-4">Normalisasi dilakukan untuk menyetarakan nilai antar alternatif terhadap solusi ideal.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                @foreach (collect($scoreWeights)->keys() as $row)
                                    <th class="border px-4 py-2 capitalize">{{ str_replace("_", " ", $row) }}</th>
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
                                    <td class="border px-4 py-2">{{ $row['nama']  }}</td>
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

                <section class="mt-5 bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold text-orange-500 mb-2">5. Matriks Tertimbang</h2>
                    <p class="text-gray-600 mb-4">Nilai normalisasi dikalikan dengan bobot kriteria untuk memperoleh nilai tertimbang.</p>
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                @foreach (collect($scoreWeights)->keys() as $row)
                                    <th class="border px-4 py-2 capitalize">{{ str_replace("_", " ", $row) }}</th>
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
                                    <td class="border px-4 py-2">{{ $row['nama']  }}</td>
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
                            @foreach ($ranking as $index => $row)
                                <tr>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    <td class="border px-4 py-2">{{ $row['fk'] }}</td>
                                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
    </x-app-layout>
</body>