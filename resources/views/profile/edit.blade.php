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

        @if ($role == 'KepalaSekolah')
            @include('components.sidebar-kepsek')
        @elseif ($role == 'Admin')
            @include('components.sidebar-admin')
        @elseif ($role == 'Guru')
            @include('components.sidebar-guru')
        @else
            @include('components.sidebar-siswa')
        @endif

            <div class="flex flex-1 justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl w-full space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>
