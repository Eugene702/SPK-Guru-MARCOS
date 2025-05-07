<title>@yield('title', 'Data Sub Kriteria')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="bg-white text-black">
<x-app-layout>
    <div class="flex min-h-screen">
        @include('components.sidebar-admin')

        <!-- Konten lainnya di sini -->
        <main class="flex-1 p-10">
            <h1 class="text-2xl font-bold">Data Sub Kriteria</h1>

            {{-- looping nama kriteria yang ada subkriterianya aja --}}
            @foreach($kriterias as $kriteria)
            @if($kriteria->subKriterias->isNotEmpty())
            <div class="mb-10 mt-5">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Kriteria {{ $kriteria->nama_kriteria }}</h2>
                </div>

                {{-- Table start --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr class="bg-thead text-center">
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Nama Sub Kriteria</th>
                                <th class="px-4 py-2 border">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kriteria->subKriterias as $index => $sub)
                                <tr class="border-b text-center">
                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $sub->nama_sub_kriteria }}</td>
                                    <td class="px-4 py-2 border">{{ $sub->bobot_sub_kriteria }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Table end --}}
            </div>
            @endif
            @endforeach
        </main>
    </div>
</x-app-layout>
</body>