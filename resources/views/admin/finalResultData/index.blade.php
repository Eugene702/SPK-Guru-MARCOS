<title>@yield('title', 'Data Perhitungan')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body>
    <x-app-layout>
        <div class="flex h-screen">
            @include('components.sidebar-admin')

            <main class="flex-1 p-10">
                <h1 class="text-2xl font-bold">Data Hasil Akhir</h1>

                <div class="mt-10">
                    <table class="table-auto border-collapse border border-gray-300 w-full mb-4">
                        <thead class="bg-thead">
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Nama Guru</th>
                                <th class="border px-4 py-2">Nilai</th>
                                <th class="border px-4 py-2">Ranking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasil as $index => $row)
                                <tr class="text-center border-b">
                                    <td class="border px-4 py-2 font-bold">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ $row['nama'] }}</td>
                                    <td class="border px-4 py-2 font-semibold">{{ number_format($row['f_ki'], 4) }}</td>
                                    <td class="border px-4 py-2 font-bold">{{ $row['ranking'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </x-app-layout>
</body>