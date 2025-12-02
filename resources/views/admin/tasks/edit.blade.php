<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Tugas') }}
            </h2>
            <a href="{{ route('admin.tasks') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Kembali') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.tasks.update', $task) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Judul -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Judul Tugas') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}"
                                       class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Deskripsi Tugas') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4"
                                          class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                          required>{{ old('description', $task->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ditugaskan Ke -->
                            <div>
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Ditugaskan Ke') }} <span class="text-red-500">*</span>
                                </label>
                                <select name="assigned_to" id="assigned_to"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                    <option value="all_users" {{ old('assigned_to', $task->assigned_to) == 'all_users' ? 'selected' : '' }}>
                                        {{ __('Semua User') }}
                                    </option>
                                    <option value="specific_users" {{ old('assigned_to', $task->assigned_to) == 'specific_users' ? 'selected' : '' }}>
                                        {{ __('User Tertentu') }}
                                    </option>
                                </select>
                                @error('assigned_to')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deadline -->
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Deadline') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date->format('Y-m-d\TH:i')) }}"
                                       class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                                @error('due_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- User Tertentu -->
                            <div id="users_section" class="md:col-span-2" style="display: {{ old('assigned_to', $task->assigned_to) == 'specific_users' ? 'block' : 'none' }};">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Pilih User') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-48 overflow-y-auto border border-gray-300 dark:border-gray-700 rounded-md p-3">
                                    @foreach($users as $user)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="selected_users[]" value="{{ $user->id }}"
                                                   {{ in_array($user->id, old('selected_users', $task->assignments->pluck('user_id')->toArray())) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                {{ $user->name }} ({{ $user->nim }})
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('selected_users')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gambar -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Gambar (Opsional)') }}
                                </label>
                                @if($task->image_path)
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($task->image_path) }}" alt="Current Image" class="w-32 h-32 object-cover rounded-md">
                                        <p class="text-sm text-gray-500 mt-1">{{ __('Gambar Saat Ini') }}</p>
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Link -->
                            <div>
                                <label for="link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Link (Opsional)') }}
                                </label>
                                <input type="url" name="link" id="link" value="{{ old('link', $task->link) }}"
                                       class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="https://example.com">
                                @error('link')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.tasks') }}"
                               class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600 px-4 py-2 rounded-md text-sm font-medium mr-3">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                {{ __('Update Tugas') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('assigned_to').addEventListener('change', function() {
            const usersSection = document.getElementById('users_section');
            if (this.value === 'specific_users') {
                usersSection.style.display = 'block';
            } else {
                usersSection.style.display = 'none';
            }
        });
    </script>
</x-app-layout>
