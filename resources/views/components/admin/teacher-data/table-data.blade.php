<div x-data="{
    editId: null,
    data: {{ $gurus }},
}">
    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead class="bg-thead">
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">NIP</th>
                <th class="border px-4 py-2">Nama Guru</th>
                <th class="border px-4 py-2">Jabatan</th>
                <th class="border px-4 py-2">Kelas</th>
                <th class="border px-4 py-2">Mata Pelajaran</th>
                <th class="border px-4 py-2">Jumlah Jam Mengajar</th>
                <th class="border px-4 py-2">Jumlah Presensi</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gurus as $index => $guru)
                <tr class="text-center border-b">
                    <td class="border px-2 py-1">{{ $index + 1 }}</td>
                    <td class="border px-2 py-1">{{ $guru->nip }}</td>
                    <td class="border px-2 py-1">
                        @if ($guru->user)
                            {{ $guru->user->name }}
                        @else
                            Data user tidak tersedia
                        @endif
                    </td>
                    <td class="border px-2 py-1">{{ $guru->jabatan }}</td>
                    <td class="border px-2 py-1">
                        @foreach ($guru->kelas as $kelas)
                            <div>{{ $kelas->nama_kelas }}</div>
                        @endforeach
                    </td>
                    <td class="border px-2 py-1">
                        @foreach ($guru->mataPelajarans as $mapel)
                            <div>{{ $mapel->nama_mata_pelajaran }}</div>
                        @endforeach
                    </td>
                    <td class="border px-2 py-1">{{ $guru->jumlah_jam_mengajar }}</td>
                    <td class="border px-2 py-1">{{ $guru->jumlah_presensi }}</td>
                    <td class="border px-2 py-1">{{ $guru->user?->email ?? '-' }}</td>
                    <td class="border px-2 py-1 flex justify-center gap-2">
                        <button @click="editId = {{ $guru->id }}" class="text-yellow-500 hover:text-yellow-700">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('admin.dataguru.destroy', $guru->id) }}" method="POST"
                            class="deleteUser" onsubmit="return handleOnClickDelete(event)">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700"><i
                                    class="fa-solid fa-trash"></i></button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <x-admin.teacher-data.edit-modal :$opsiKelas :$mataPelajarans />
</div>
