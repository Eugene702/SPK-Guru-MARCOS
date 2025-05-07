<title>@yield('title', 'Data Kriteria')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-white text-black">
<x-app-layout>
    <div class="flex h-screen">
        @include('components.sidebar-admin')

        {{-- Konten lainnya disini --}}
        <main class="flex-1 p-10">
            <h1 class="text-2xl font-bold">Data Kriteria</h1>
        
            <div class="overflow-x-auto mt-10">
                {{-- Table start --}}
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr class="bg-thead text-center">
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Kriteria</th>
                            <th class="px-4 py-2 border">Bobot Kriteria</th>
                            <th class="px-4 py-2 border">Jenis Kriteria</th>
                            <th class="px-4 py-2 border">Cara Penilaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriterias as $index => $kriteria)
                        <tr class="border-b text-center">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $kriteria->nama_kriteria }}</td>
                            <td class="px-4 py-2 border">{{ $kriteria->bobot_kriteria }}</td>
                            <td class="px-4 py-2 border">{{ $kriteria->jenis }}</td>
                            <td class="px-4 py-2 border">{{ $kriteria->cara_penilaian }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Table end --}}
            </div>
        </main>
    </div>
</x-app-layout>
</body>
