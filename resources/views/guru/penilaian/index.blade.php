<title>@yield('title', 'Data Penilaian')</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<body class="text-black bg-creamy">
    <x-app-layout>
        <div class="flex h-screen">
            @include('components.sidebar-guru')
            <main class="flex-1 p-10 overflow-auto">
                <div class="mb-10">
                    <div class="text-gray-800 text-center rounded-xl shadow-md p-6 bg-amber-400/25">
                        <h2 class="text-3xl font-bold mb-2">📋 Penilaian Guru oleh Rekan Sejawat</h2>
                        <p class="text-md">
                            Selamat datang di halaman penilaian guru. Di sini, Anda dapat memberikan evaluasi secara
                            objektif terhadap performa guru dalam berbagai aspek.
                            <br>
                            <span class="font-semibold">✨ Tujuan utama penilaian ini adalah untuk meningkatkan kualitas
                                pendidikan melalui apresiasi dan pengembangan berkelanjutan.</span>
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6">
                    <p class="text-center mb-4">Silakan isi penilaian berdasarkan kuesioner yang tersedia.</p>
                    <div class="text-xl font-bold">Belum dinilai</div>
                    <x-teacher.assessment.ungraded-table :gurus="$gurus" />
                </div>

                <div class="overflow-x-auto max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6 mt-5">
                    <p class="text-center mb-4">Silakan isi penilaian berdasarkan kuesioner yang tersedia.</p>
                    <div class="text-xl font-bold">Sudah dinilai</div>
                    <x-teacher.assessment.already-graded-table :gurus="$gurus" />
                </div>
            </main>
        </div>
    </x-app-layout>
</body>
