<div>
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Bills List -->
    <div class="space-y-4">
        @forelse($bills as $bill)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    NIM: {{ auth()->user()->nim }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    kirim ke No Rekening:<br> {{ 70212123213 }}-admin
                                </div>
                            </div>
                        </div>
                        @if($bill->status === 'paid')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                {{ __('Paid') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                {{ __('Unpaid') }}
                            </span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ $bill->description }}
                        </h3>
                        <div class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            Rp {{ number_format($bill->amount, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Due Date') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $bill->due_date ? $bill->due_date->format('d/m/Y') : '-' }}</span>
                        </div>
                        @if($bill->paid_at)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Paid At') }}:</span>
                                <span class="text-gray-900 dark:text-white">{{ $bill->paid_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        @if($bill->proof_path)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Proof') }}:</span>
                                <a href="{{ Storage::url($bill->proof_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">View Proof</a>
                            </div>
                        @endif
                    </div>

                    @if($bill->status === 'unpaid')
                        <x-button
                            wire:click="openUploadModal({{ $bill->id }})"
                            class="bg-blue-600 hover:bg-blue-700 text-xs px-3 py-2"
                        >
                            {{ __('Upload Proof') }}
                        </x-button>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <div class="text-gray-500 dark:text-gray-400 text-lg">
                    {{ __('No bills found.') }}
                </div>
            </div>
        @endforelse
    </div>

    <!-- Upload Modal -->
    <x-dialog-modal wire:model="showUploadModal">
        <x-slot name="title">
            {{ __('Upload Proof of Transfer') }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="proof" value="{{ __('Select File') }}" />
                    <x-input wire:model="proof" id="proof" type="file" class="w-full" accept="image/*,.pdf" />
                    <x-input-error for="proof" />
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Accepted formats: JPG, JPEG, PNG, PDF. Maximum size: 2MB.') }}
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeUploadModal">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button wire:click="uploadProof" class="ml-3">
                {{ __('Upload') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
