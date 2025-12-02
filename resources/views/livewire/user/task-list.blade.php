<div class=" min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-7 py-7">
        <div class="bg-transparent overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 lg:p-8 border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Daftar Tugas</h2>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Kembali
                    </a>
                </div>

                @if($tasks->count() > 0)
                    <div class="space-y-4">
                        @foreach($tasks as $task)
                            <div class="bg-blue-100 rounded-lg p-3 border">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">

                                        <h3 class="text-lg font-semibold text-gray-900 bg-blue-100 p-1 rounded">{{ $task->title }}</h3>

                                        <p class="text-gray-600 mt-2">{{ Str::limit($task->description, 50) }}</p>



                                        @if($task->image_path)
                                            <div class="mt-3">
                                                <img src="{{ Storage::url($task->image_path) }}" alt="{{ $task->title }}" class="w-full h-32 object-cover rounded-lg">
                                            </div>
                                        @endif

                                        @if($task->due_date)
                                            <div class="mt-2">
                                                <span class="text-sm text-gray-500">Deadline: </span>
                                                <span class="text-sm font-medium text-red-600" id="deadline-{{ $task->id }}">
                                                    {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                                </span>
                                                <div class="mt-1" x-data="countdownTimer({{ $task->due_date->timestamp * 1000 }})" x-init="init()">
                                                    <span class="text-sm text-gray-500">Sisa waktu: </span>
                                                    <span class="text-sm font-medium text-orange-600" x-text="timeString" x-bind:class="isOverdue ? 'text-red-600' : 'text-orange-600'">
                                                        Menghitung...
                                                    </span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="mt-3 flex items-center space-x-4">
                                            @if($task->submissions->where('user_id', auth()->id())->first())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Sudah Dikirim
                                                </span>
                                                <a href="{{ route('user.tasks.answers') }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    Jawaban Saya
                                                </a>
                                            @else
                                                <a href="{{ route('user.tasks.detail', $task->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    Lihat Detail & Kirim
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Tidak ada tugas yang tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function countdownTimer(deadline) {
            return {
                deadline: new Date(deadline).getTime(),
                timeString: 'Menghitung...',
                isOverdue: false,
                init() {
                    this.updateTimer();
                    setInterval(() => {
                        this.updateTimer();
                    }, 1000);
                },
                updateTimer() {
                    const now = new Date().getTime();
                    const distance = this.deadline - now;

                    if (distance < 0) {
                        this.timeString = 'Waktu Habis';
                        this.isOverdue = true;
                        return;
                    }

                    this.isOverdue = false;
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    this.timeString = days + ' hari ' + hours + ' jam ' + minutes + ' menit ' + seconds + ' detik';
                }
            }
        }
    </script>
</div>
