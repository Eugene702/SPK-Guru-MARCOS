<div>
    <table class="min-w-full table-auto border border-gray-200">
        <thead class="bg-thead">
            <tr>
                <th class="px-6 py-3 border">No</th>
                <th class="px-6 py-3 border">Nama Guru</th>
                <th class="px-6 py-3 border">Nilai</th>
                <th class="px-6 py-3 border">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($gurus as $index => $guru)
                @php
                    $penilaian = \App\Models\PenilaianOlehRekanSejawat::where(
                        'penilai_id',
                        '=',
                        auth()->user()->guru->id,
                    )
                        ->where('guru_id', '=', $guru->id)
                        ->whereYear('created_at', now()->year)
                        ->first();

                    if($penilaian){
                        continue;
                    }
                @endphp
                <tr class="text-center">
                    {{-- Nomor --}}
                    <td class="px-6 py-4 border">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 border">{{ $guru->user->name }}</td>
                    <td class="px-6 py-4 border">
                        @if ($penilaian)
                            {{ number_format($penilaian->nilai_akhir, 2) }}%
                        @else
                            <span class="text-gray-400 italic">Belum dinilai</span>
                        @endif
                    </td>
                    {{-- Aksi --}}
                    <td class="px-6 py-4 border">
                        <a href="{{ route('guru.penilaian.form', $guru->id) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                            Nilai
                        </a>
                    </td>
                    {{-- Aksi End --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
