<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jawaban Saya') }}
            </h2>
            <a href="{{ route('user.tasks') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Kembali ke Daftar Tugas') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    @if($submissions->count() > 0)
                        <div class="space-y-6">
                            @foreach($submissions as $submission)
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $submission->task->title }}</h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Dikirim pada: {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 text-sm rounded-full
                                            @if($submission->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($submission->status === 'approved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </div>

                                    <div class="mb-4">
                                        <h4 class="text-md font-medium text-gray-900 mb-2">Jawaban:</h4>
                                        <div class="bg-white p-4 rounded border">
                                            <p class="text-gray-700 whitespace-pre-wrap">{{ $submission->answer }}</p>
                                        </div>
                                    </div>

                                    @if($submission->file_path)
                                        <div class="mb-4">
                                            <h4 class="text-md font-medium text-gray-900 mb-2">File Lampiran:</h4>
                                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586 11.293 8.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 011.414-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                Lihat File ({{ basename($submission->file_path) }})
                                            </a>
                                        </div>
                                    @endif

                                    <div class="flex space-x-2">
                                        <a href="{{ route('user.tasks.detail', $submission->task->id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Lihat Detail Tugas
                                        </a>
                                        <a href="{{ route('user.tasks.submit', $submission->task->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Edit Jawaban
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('Belum ada jawaban yang dikirim') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Mulai kirim jawaban untuk tugas yang tersedia.') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('user.tasks') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Lihat Tugas
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
