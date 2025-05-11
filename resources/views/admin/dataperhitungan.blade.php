<title>@yield('title', 'Data Perhitungan')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-white text-black">
    <x-app-layout>
        <div class="flex min-h-screen">
            @include('components.sidebar-admin')

            <!-- Konten dashboard lainnya di sini -->
            <main class="flex-1 p-10">
                <h1 class="text-2xl font-bold">Data Perhitungan</h1>
                <section class="mt-5">
                    <h1 class="text-2xl font-semibold text-center">Perhitungan MARCOS</h1>
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

                <section class="mt-5">
                    <h1 class="text-2xl font-semibold text-center">Hasil Skor Linguistik</h1>
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

                <section class="mt-5">
                    <h1 class="text-2xl font-semibold text-center">Nilai Ideal & Anti-Ideal</h1>
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

                <section class="mt-5">
                    <h1 class="text-2xl font-semibold text-center">Normalisasi Matriks Keputusan</h1>
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

                <section class="mt-5">
                    <h1 class="text-2xl font-semibold text-center">Skor Tertimbang</h1>
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

                <section class="mt-5">
                    <h1 class="text-2xl font-semibold text-center">Hasil Akhir</h1>
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

                <section class="mt-5">
                    <h1 class="text-2xl font-semibold text-center">Perhitungan Skor Akhir</h1>
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

                <section class="mt-5">
                    <h1 class="text-2xl font-semibold text-center">Rangking</h1>
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