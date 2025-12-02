<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Task Details') }}
            </h2>
            <a href="{{ route('admin.tasks') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Tasks') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">{{ $task->title }}</h3>

                    <div class="mb-6">
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $task->description }}</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <strong>{{ __('Dibuat Oleh') }}:</strong> {{ $task->creator->name }}
                            </div>
                            <div>
                                <strong>{{ __('Tanggal Jatuh Tempo') }}:</strong> {{ $task->due_date->format('d M Y H:i') }}
                                @if($task->isOverdue())
                                    <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full mt-1 ml-2">{{ __('Overdue') }}</span>
                                @endif
                            </div>
                            <div>
                                <strong>{{ __('Assigned To') }}:</strong>
                                @if($task->assigned_to === 'all_users')
                                    {{ __('All Users') }}
                                @else
                                    {{ $task->assignments->count() }} {{ __('Users') }}
                                @endif
                            </div>
                            <div>
                                <strong>{{ __('Total Sudah Mengumpulkan') }}:</strong> {{ $task->submissions->count() }}
                            </div>
                            <div>
                                <strong>{{ __('Total Belum Mengumpulkan') }}:</strong> {{ $nonSubmitters->count() }}
                            </div>
                        </div>

                        @if($task->image_path)
                            <div class="mb-4">
                                <strong>{{ __('Image') }}:</strong><br>
                                <img src="{{ asset('storage/' . $task->image_path) }}" alt="Task Image" class="max-w-md mt-2 rounded">
                            </div>
                        @endif

                        @if($task->link)
                            <div class="mb-4">
                                <strong>{{ __('Link') }}:</strong>
                                <a href="{{ $task->link }}" target="_blank" class="text-blue-500 hover:text-blue-700">{{ $task->link }}</a>
                            </div>
                        @endif
                    </div>

                    <div class="border-t pt-6">
                        <h4 class="text-xl font-semibold mb-4">{{ __('Submissions') }}</h4>

                        @if($task->submissions->count() > 0)
                            <div class="space-y-4">
                                @foreach($task->submissions as $submission)
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <strong>{{ $submission->user->name }}</strong> ({{ $submission->user->nim }})
                                                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">
                                                    {{ $submission->created_at->format('d M Y H:i') }}
                                                </span>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($submission->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($submission->status === 'approved') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300">{{ $submission->answer }}</p>

                                        <div class="mt-4 flex space-x-2">
                                            <form method="POST" action="{{ route('admin.tasks.submissions.update-status', [$task, $submission]) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="px-3 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600">Approve</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.tasks.submissions.update-status', [$task, $submission]) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">Reject</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.tasks.submissions.update-status', [$task, $submission]) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="px-3 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600">Pending</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No submissions yet.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
