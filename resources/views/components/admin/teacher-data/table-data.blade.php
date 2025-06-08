<div x-data="{
    editId: null,
    data: {{ $gurus }},
    handleOnClickDelete(e, data) {
        Swal.fire({
            title: 'Hapus guru!',
            text: `Apakah kamu yakin ingin menghapus guru ${data.user.name} ini?`,
            icon: 'warning', 
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            confirmButtonColor: '#ffd480',
            cancelButtonColor: '#d1d5db',
            focusCancel: true,
            customClass: {
                confirmButton: 'swal-confirm-btn text-black',
                cancelButton: 'swal-cancel-btn text-black'
            }
        }).then(result => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        })
    }
}">

    <table class="table-auto divide-y divide-gray-200">
        <thead class="bg-thead text-black">
            <tr>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[50px]">No</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[150px]">NIP</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[200px]">Nama Guru</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[120px]">Jabatan</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[70px]">Kelas</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[200px]">Mata Pelajaran</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[120px]">Jam Mengajar</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[100px]">Presensi</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[200px]">Email</th>
                <th class="px-4 py-3 text-sm font-semibold text-center border min-w-[100px]">Aksi</th>
            </tr>
        </thead>

        <tbody class="bg-white text-gray-800">
            @foreach ($gurus as $index => $guru)
                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} text-center hover:bg-yellow-50 transition">
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>

                    <td class="px-4 py-2 border whitespace-nowrap overflow-hidden text-ellipsis relative">
                        <div x-data="{ show: false, tooltipX: 0, tooltipY: 0 }" @mouseenter="show = true" @mouseleave="show = false"
                            @mousemove="tooltipX = $event.clientX; tooltipY = $event.clientY" class="relative">
                            <span>{{ $guru->nip }}</span>
                            <div x-show="show" x-transition
                                :style="`top: ${tooltipY + 10}px; left: ${tooltipX + 10}px`"
                                class="absolute z-50 bg-black text-white text-xs px-2 py-1 rounded shadow pointer-events-none whitespace-nowrap">
                                {{ $guru->nip }}
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-2 border whitespace-nowrap overflow-hidden text-ellipsis relative">
                         <div x-data="{ show: false, tooltipX: 0, tooltipY: 0 }" @mouseenter="show = true" @mouseleave="show = false"
                            @mousemove="tooltipX = $event.clientX; tooltipY = $event.clientY" class="relative">
                            <span>{{ $guru->user->name ?? 'Data user tidak tersedia' }}</span>
                             <div x-show="show" x-transition
                                :style="`top: ${tooltipY + 10}px; left: ${tooltipX + 10}px`"
                                class="absolute z-50 bg-black text-white text-xs px-2 py-1 rounded shadow pointer-events-none whitespace-nowrap">
                                {{ $guru->user->name ?? 'Data user tidak tersedia' }}
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-2 border whitespace-nowrap overflow-hidden text-ellipsis relative">
                        <div x-data="{ show: false, tooltipX: 0, tooltipY: 0 }" @mouseenter="show = true" @mouseleave="show = false"
                            @mousemove="tooltipX = $event.clientX; tooltipY = $event.clientY" class="relative">
                            <span>{{ $guru->jabatan }}</span>
                            <div x-show="show" x-transition
                                :style="`top: ${tooltipY + 10}px; left: ${tooltipX + 10}px`"
                                class="absolute z-50 bg-black text-white text-xs px-2 py-1 rounded shadow pointer-events-none whitespace-nowrap">
                                {{ $guru->jabatan }}
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-2 border text-left whitespace-nowrap overflow-hidden text-ellipsis relative">
                        <div x-data="{ show: false, tooltipX: 0, tooltipY: 0 }" @mouseenter="show = true" @mouseleave="show = false"
                            @mousemove="tooltipX = $event.clientX; tooltipY = $event.clientY" class="relative">
                            @foreach ($guru->kelas as $kelas)
                                <div>{{ $kelas->nama_kelas }}</div>
                            @endforeach
                            @if ($guru->kelas->isNotEmpty())
                                <div x-show="show" x-transition
                                    :style="`top: ${tooltipY + 10}px; left: ${tooltipX + 10}px`"
                                    class="absolute z-50 bg-black text-white text-xs px-2 py-1 rounded shadow pointer-events-none whitespace-nowrap">
                                    @foreach ($guru->kelas as $kelas)
                                        {{ $kelas->nama_kelas }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </td>

                    <td class="px-4 py-2 border text-left whitespace-nowrap overflow-hidden text-ellipsis relative">
                        <div x-data="{ show: false, tooltipX: 0, tooltipY: 0 }" @mouseenter="show = true" @mouseleave="show = false"
                            @mousemove="tooltipX = $event.clientX; tooltipY = $event.clientY" class="relative">
                            @foreach ($guru->mataPelajarans as $mapel)
                                <div>{{ $mapel->nama_mata_pelajaran }}</div>
                            @endforeach
                            @if ($guru->mataPelajarans->isNotEmpty())
                                <div x-show="show" x-transition
                                    :style="`top: ${tooltipY + 10}px; left: ${tooltipX + 10}px`"
                                    class="absolute z-50 bg-black text-white text-xs px-2 py-1 rounded shadow pointer-events-none whitespace-nowrap">
                                    @foreach ($guru->mataPelajarans as $mapel)
                                        {{ $mapel->nama_mata_pelajaran }}<br>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </td>

                    <td class="px-4 py-2 border">{{ $guru->jumlah_jam_mengajar }}</td>
                    <td class="px-4 py-2 border">{{ $guru->jumlah_presensi }}</td>

                    <td class="px-4 py-2 border whitespace-nowrap overflow-hidden text-ellipsis relative">
                        <div x-data="{ show: false, tooltipX: 0, tooltipY: 0 }" @mouseenter="show = true" @mouseleave="show = false"
                            @mousemove="tooltipX = $event.clientX; tooltipY = $event.clientY" class="relative">
                            <span>{{ $guru->user?->email ?? '-' }}</span>
                            <div x-show="show" x-transition
                                :style="`top: ${tooltipY + 10}px; left: ${tooltipX + 10}px`"
                                class="absolute z-50 bg-black text-white text-xs px-2 py-1 rounded shadow pointer-events-none whitespace-nowrap">
                                {{ $guru->user?->email ?? '-' }}
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-2 border">
                        <div class="flex justify-center items-start gap-4 text-lg">
                            <button @click="editId = {{ $guru->id }}" class="text-yellow-500 hover:text-yellow-700"
                                title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.dataguru.destroy', $guru->id) }}" method="POST"
                                @submit.prevent="() => handleOnClickDelete($event, {{ $guru }})">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <x-admin.teacher-data.edit-modal :$opsiKelas :$mataPelajarans />
</div>