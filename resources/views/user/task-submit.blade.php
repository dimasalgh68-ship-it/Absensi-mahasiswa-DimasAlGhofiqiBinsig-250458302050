<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kirim Jawaban Tugas') }}
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

                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">
                            @if(isset($existingSubmission))
                                Form Perbarui Jawaban
                            @else
                                Form Pengiriman Jawaban
                            @endif
                        </h4>
                        <form action="{{ route('user.tasks.submit.store', $task->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban <span class="text-red-500">*</span></label>
                                <textarea id="answer" name="answer" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis jawaban lengkap Anda di sini..." required>{{ old('answer', isset($existingSubmission) ? $existingSubmission->answer : '') }}</textarea>
                                @error('answer')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label for="file" class="block text-sm font-medium text-gray-700">File Pendukung (Opsional)</label>
                                @if(isset($existingSubmission) && $existingSubmission->file_path)
                                    <div class="mb-2">
                                        <p class="text-sm text-gray-600">File saat ini: <a href="{{ Storage::url($existingSubmission->file_path) }}" target="_blank" class="text-blue-500 hover:text-blue-700">{{ basename($existingSubmission->file_path) }}</a></p>
                                    </div>
                                @endif
                                <input type="file" id="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-sm text-gray-500">Format yang didukung: PDF, DOC, DOCX, JPG, JPEG, PNG. Maksimal 10MB. @if(isset($existingSubmission) && $existingSubmission->file_path) Biarkan kosong jika tidak ingin mengubah file. @endif</p>
                                @error('file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center justify-between">
                                <a href="{{ route('user.tasks.detail', $task->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Batal
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    @if(isset($existingSubmission))
                                        Perbarui Jawaban
                                    @else
                                        Kirim Jawaban
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deadline = new Date('{{ $task->deadline }}').getTime();
            const timerElement = document.getElementById('countdown-timer');

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
        });
    </script>
</x-app-layout>
