<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<x-app-layout>

    <body class="text-black bg-creamy">
        <div class="flex h-screen">
            @include('components.sidebar-admin')
            <main class="flex-1 p-10">
                <h1 class="text-2xl font-bold">Selamat Datang {{ auth()->user()->name }}</h1>
                <table class="w-full border-collapse my-10">
                    <thead>
                        <tr>
                            <th class="bg-blue-900 text-white font-medium text-center py-3 px-2">Peringkat</th>
                            <th class="bg-blue-900 text-white font-medium text-center py-3 px-2">Nama Alternatif</th>
                            <th class="bg-blue-900 text-white font-medium text-center py-3 px-2">Nilai Akhir</th>
                            <th class="bg-blue-900 text-white font-medium text-center py-3 px-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ranking as $row)
                            <tr class="bg-amber-50/50">
                                <td class="py-2 px-3 text-center font-bold border-b border-gray-200">
                                    {{ $loop->iteration }}</td>
                                <td class="py-2 px-3 text-center border-b border-gray-200"><i
                                        class="text-yellow-500 mr-1 text-lg"></i>{{ $row['nama'] }}</td>
                                <td class="py-2 px-3 text-center border-b border-gray-200">{{ number_format($row['fk'] * 100, 2) }}%</td>
                                @if ($loop->iteration == 1)
                                    <td class="py-2 px-3 text-center border-b border-gray-200"><span
                                            class="bg-green-700 text-white px-2 py-1 rounded text-xs font-medium">Terbaik</span>
                                    </td>
                                @else
                                    <td class="py-2 px-3 text-center border-b border-gray-200">-</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-steps-conducting-assessment />
            </main>
        </div>
    </body>

</x-app-layout>
