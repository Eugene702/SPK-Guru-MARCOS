<title>@yield('title', 'Data Perhitungan')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body>
    <x-app-layout>
        <div class="flex h-screen">
            @include('components.sidebar-admin')

            <main class="flex-1 p-10">
                <h1 class="text-2xl font-bold">Data Hasil Akhir</h1>
                <div class="flex justify-end">
                    <a href="{{ route('admin.final-result-data.print') }}" class="bg-green-600 text-white px-4 py-2 rounded bg flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="fill-white w-3"><path d="M128 0C92.7 0 64 28.7 64 64l0 96 64 0 0-96 226.7 0L384 93.3l0 66.7 64 0 0-66.7c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0L128 0zM384 352l0 32 0 64-256 0 0-64 0-16 0-16 256 0zm64 32l32 0c17.7 0 32-14.3 32-32l0-96c0-35.3-28.7-64-64-64L64 192c-35.3 0-64 28.7-64 64l0 96c0 17.7 14.3 32 32 32l32 0 0 64c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-64zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
                        <span>Cetak</span>
                    </a>
                </div>

                <div class="mt-10">
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
                </div>
            </main>
        </div>
    </x-app-layout>
</body>