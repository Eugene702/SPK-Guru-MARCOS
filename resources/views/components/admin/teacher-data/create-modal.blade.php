<div x-data="{
    open: false,
    role: '',
    subject: [],
    classLevel: [],
    teachingHour: '',
    totalAttendance: '',
    reset() {
        this.subject = []
        this.classLevel = []
        this.teachingHour = ''
        this.totalAttendance = ''
    },
    handleSubmit(e) {
        if (this.role === 'KepalaSekolah') {
            e.target.submit()
        } else {
            const response = { isValid: false, message: '' }
            if (this.subject.length === 0) {
                response.isValid = true
                response.message = 'Mohon pilih Mata Pelajaran'
            }

            if (this.classLevel.length === 0) {
                response.isValid = true
                response.message = `${response.message}\nMohon pilih Kelas`
            }

            if (response.isValid) {
                Swal.fire({
                    title: 'Ada yang salah!',
                    html: response.message,
                    icon: 'warning',
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                })
            } else {
                e.target.submit()
            }
        }
    }
}" x-init="$watch('role', value => value === 'KepalaSekolah' ? reset() : null)">
    <div class="flex justify-end mb-2">
        <button class="bg-green-600 text-white px-4 py-2 rounded mb-4" x-on:click="open = true">Tambah Data</button>
    </div>

    <div x-show="open" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[95%] max-w-screen-xl">
            <h2 class="text-xl font-bold mb-6 text-center">Tambah Data Guru</h2>
            <form action="{{ route('admin.dataguru.storeguru') }}" method="POST" @submit.prevent="handleSubmit">
                @csrf
                <div class="grid grid-cols-4 gap-6">

                    <div class="space-y-4">
                        <h4 class="text-md font-semibold mb-2 text-center">User Info</h4>
                        <div>
                            <label class="block mb-1 text-sm">Nama Guru</label>
                            <input type="text" name="name"
                                class="w-full border p-2 rounded-md border-gray-300 shadow-sm" placeholder="Nama Guru"
                                required>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm">Email</label>
                            <input type="email" name="email"
                                class="w-full border p-2 rounded-md border-gray-300 shadow-sm" placeholder="Email"
                                required>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm">Password</label>
                            <input type="password" name="password"
                                class="w-full border p-2 rounded-md border-gray-300 shadow-sm" placeholder="Password"
                                minlength="6" required>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm">Role</label>
                            <select name="role" class="w-full border px-3 py-2 rounded-md border-gray-300 shadow-sm"
                                required x-model="role">
                                <option value="">-- Pilih Role --</option>
                                <option value="Guru">Guru</option>
                                <option value="KepalaSekolah">KepalaSekolah</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-md font-semibold mb-2 text-center">Guru Info</h4>
                        <div>
                            <label class="block mb-1 text-sm">NIP</label>
                            <input type="text" name="nip"
                                class="w-full border p-2 rounded-md border-gray-300 shadow-sm" placeholder="NIP"
                                required>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm">Jabatan</label>
                            <select name="jabatan" class="w-full border px-3 py-2 rounded-md border-gray-300 shadow-sm"
                                required>
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="Guru">Guru</option>
                                <option value="Kepala Sekolah">Kepala Sekolah</option>
                            </select>
                        </div>
                        <div x-show="role != 'KepalaSekolah'" x-cloak>
                            <label class="block mb-1 text-sm">Jumlah Jam Mengajar</label>
                            <input type="number" name="jumlah_jam_mengajar"
                                class="w-full border p-2 rounded-md border-gray-300 shadow-sm teachingHour"
                                placeholder="Jumlah Jam Mengajar" :required="role != 'KepalaSekolah'" x-model="teachingHour">
                        </div>
                        <div x-show="role != 'KepalaSekolah'" x-cloak>
                            <label class="block mb-1 text-sm">Jumlah Presensi</label>
                            <input type="number" name="jumlah_presensi"
                                class="w-full border p-2 rounded-md border-gray-300 shadow-sm totalAttendance"
                                placeholder="Jumlah Presensi" :required="role != 'KepalaSekolah'" x-model="totalAttendance">
                        </div>
                    </div>

                    <div class="space-y-4" x-show="role != 'KepalaSekolah'" x-cloak>
                        <h4 class="text-md font-semibold mb-2 text-center">Pilih Mata Pelajaran</h4>
                        <div
                            class="h-[300px] overflow-y-auto border p-3 space-y-2 rounded-md border-gray-300 shadow-sm">
                            @foreach ($mataPelajarans as $mapel)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="mata_pelajaran[]" value="{{ $mapel->id }}"
                                        x-model="subject" class="accent-green-500">
                                    <span>{{ $mapel->nama_mata_pelajaran }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-4" x-show="role != 'KepalaSekolah'" x-cloak>
                        <h4 class="text-md font-semibold mb-2 text-center">Pilih Kelas</h4>
                        <div
                            class="h-[300px] overflow-y-auto border p-3 space-y-2 rounded-md border-gray-300 shadow-sm">
                            @foreach ($opsiKelas as $item)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" class="classLevel" name="kelas[]" value="{{ $item->id }}"
                                        x-model="classLevel" /> <span>{{ $item->nama_kelas }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" x-on:click="open = false"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-sidebar text-gray-800 rounded hover:bg-thead">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
