<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-Terjadi kesalahan: SQLSTATE[HY000]: General error: 1364 Field 'answer' doesn't have a default value (Connection: mysql, SQL: insert into `task_submissions` (`task_id`, `user_id`, `updated_at`, `created_at`) values (2, 01kaxjmq2nctv4awx0p46c406p, 2025-11-26 09:41:05, 2025-11-26 09:41:05))


y-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Tugas') }}
            </h2>
            <a href="{{ route('admin.tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Buat Tugas Baru') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-300 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex-1 justify-between items-cente px-7 py-3">
            <h2 class="font-extrabold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Tugas') }}
            </h2>
            </div>
           
        </div>
                <div class="p-6 text-white">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse(\App\Models\Task::with(['assignments', 'submissions'])->latest()->get() as $task)
                            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                                {{ $task->title }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                {{ Str::limit($task->description, 100) }}
                                            </p>
                                        </div>
                                        @if($task->due_date->isPast())
                                            <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ __('Terlambat') }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ __('Aktif') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ __('Deadline') }}: {{ $task->due_date->format('d M Y H:i') }}</span>
                                        </div>

                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            <span>
                                                @if($task->assigned_to === 'all_users')
                                                    {{ __('Semua User') }}
                                                @else
                                                    {{ $task->assignments->count() }} {{ __('User') }}
                                                @endif
                                            </span>
                                        </div>

                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>{{ $task->submissions->count() }} {{ __('Submissions') }}</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.tasks.show', $task) }}"
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ __('Lihat') }}
                                        </a>
                                        <a href="{{ route('admin.tasks.edit', $task) }}"
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            {{ __('Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="inline"
                                              onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus tugas ini?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                {{ __('Hapus') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="p-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Belum ada tugas') }}</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada tugas yang dibuat.') }}</p>
                                        <div class="mt-6">
                                            <a href="{{ route('admin.tasks.create') }}"
                                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                {{ __('Buat Tugas Baru') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
