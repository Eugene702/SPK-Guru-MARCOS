<title>Edit Profil {{ auth()->user()->name }}</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen">
        @php
            $role = auth()->user()->roles()->first()->name;
        @endphp

        @if ($role == 'Admin')
            @include('components.sidebar-admin')
        @endif

        <div class="flex flex-1 justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl w-full">
                @if (auth()->user()->roles()->first()->name !== 'Admin')
                    <div class="flex justify-start mb-6">
                        <a href="{{ auth()->user()->roles()->first()->name === 'Guru'
                            ? route('guru.penilaian.index')
                            : (auth()->user()->roles()->first()->name === 'Siswa'
                                ? route('siswa.penilaiansiswa.index')
                                : (auth()->user()->roles()->first()->name === 'KepalaSekolah'
                                    ? route('kepsek.penilaian.index')
                                    : '#')) }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Halaman Penilaian
                        </a>
                    </div>
                @endif

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-2">
                    <div class="w-full">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="w-full">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
