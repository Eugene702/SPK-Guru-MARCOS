<div x-data="{ open: false, data: null }" x-init="$watch('data', value => data === null ? $refs.fileUpload.value = null : null)">
    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors"
        x-on:click="open = true">
        {{ $buttonText }}
    </button>

    <form action="{{ route($routeName) }}" enctype="multipart/form-data" method="post"
        class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50" x-show="open"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
        @csrf

        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform transition-all"
            x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" @click.outside="open = false">

            <div class="px-8 py-5 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-800">Unggah Dokumen</h3>
                    <button type="button"
                        class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none"
                        @click="open = false">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="px-8 py-6">
                <div class="space-y-6">
                    <div class="text-center">
                        <div class="bg-[#fff5e6] rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-4">
                            <svg class="h-8 w-8 text-[#ffd480]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-1">Unggah Dokumen</h4>
                        <p class="text-sm text-gray-500">Pilih dokumen dari perangkat Anda</p>
                    </div>

                    <div class="flex flex-col items-center">
                        <input type="file" class="hidden" id="fileUpload" x-on:change="e => data = e.target.files[0]"
                            x-ref="fileUpload" name="document" />
                        <label for="fileUpload" class="w-full">
                            <div
                                class="bg-[#ffd480] hover:bg-[#ffca66] text-white py-3 px-4 rounded-lg transition-all shadow-md flex items-center justify-center cursor-pointer">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Pilih File
                            </div>
                        </label>
                        <p class="text-xs text-gray-400 mt-3 text-center">XLSX (Maksimal 10MB)</p>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 rounded-lg p-4 flex items-center" x-show="data">
                        <div
                            class="h-10 w-10 flex-shrink-0 rounded-lg bg-[#fff5e6] flex items-center justify-center mr-3">
                            <svg class="h-5 w-5 text-[#ffd480]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate" x-text="data?.name"></p>
                        </div>
                        <button type="button"
                            class="ml-4 flex-shrink-0 text-gray-400 hover:text-red-500 focus:outline-none"
                            x-on:click="data = null">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="px-8 py-5 bg-gray-50 flex justify-end space-x-3">
                <button type="button"
                    class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300 font-medium"
                    @click="open = false">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-[#ffd480] text-white rounded-lg hover:bg-[#ffca66] transition-colors focus:outline-none focus:ring-2 focus:ring-[#ffd480] font-medium shadow-sm">
                    Unggah
                </button>
            </div>
        </div>
    </form>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
