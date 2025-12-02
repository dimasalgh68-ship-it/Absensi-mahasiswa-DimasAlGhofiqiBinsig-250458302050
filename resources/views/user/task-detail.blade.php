<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tugas') }}
        </h2>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $task->title }}</h3>
                        <p class="text-gray-600 mt-2">{{ $task->description }}</p>
                    </div>

                    @if($task->due_date)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-yellow-800">Deadline</p>
                                    <p class="text-sm text-yellow-700">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y H:i') }}</p>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        Sisa waktu: <span id="countdown-timer" class="font-semibold">Menghitung...</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($submission)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-green-800">{{ __('Status Pengiriman') }}</p>
                                        <p class="text-sm text-green-700">{{ __('Sudah Dikirim pada') }} {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d M Y H:i') }}</p>
                                        <p class="text-sm font-medium text-green-800 mt-1">
                                            Status Admin:
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($submission->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($submission->status === 'approved') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                @if($submission->file_path)
                                    <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586 11.293 8.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 011.414-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('Lihat Jawaban') }}
                                    </a>
                                    
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Jawaban Anda</h4>
                            <div class="prose max-w-none">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $submission->answer }}</p>
                            </div>
                            <div class="mt-4 flex justify-center">
                                <a href="{{ route('user.tasks.submit', $task->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Kirim Ulang Jawaban
                                </a>
                                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                     Kembali
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('Belum Mengirim Jawaban') }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ __('Kirim jawaban Anda sebelum deadline.') }}</p>
                                <div class="mt-6 flex justify-center space-x-4">
                                    <a href="{{ route('user.tasks.submit', $task->id) }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Kirim Jawaban
                                    </a>

                                    <a href="{{ route('user.tasks') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        {{ __('Kembali ke Daftar Tugas') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($task->due_date)
                const deadlineStr = '{{ $task->due_date }}';
                if (!deadlineStr) return;

                const deadline = new Date(deadlineStr).getTime();
                if (isNaN(deadline)) return;

                const timerElement = document.getElementById('countdown-timer');
                if (!timerElement) return;

                function updateTimer() {
                    const now = new Date().getTime();
                    const distance = deadline - now;

                    if (distance < 0) {
                        timerElement.innerHTML = 'Waktu Habis';
                        timerElement.classList.remove('text-yellow-700');
                        timerElement.classList.add('text-red-600');
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    let timeString = '';
                    if (days > 0) timeString += days + ' hari ';
                    if (hours > 0 || days > 0) timeString += hours + ' jam ';
                    timeString += minutes + ' menit ' + seconds + ' detik';

                    timerElement.innerHTML = timeString;
                }

                updateTimer();
                setInterval(updateTimer, 1000);
            @endif
        });
    </script>
</x-app-layout>
