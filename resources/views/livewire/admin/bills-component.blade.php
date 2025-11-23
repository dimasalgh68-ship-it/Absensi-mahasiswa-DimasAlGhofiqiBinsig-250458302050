<div>
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h3 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200 mb-4 sm:mb-0">
            {{ __('Bills') }}
        </h3>
        <x-button wire:click="openCreateModal" class="bg-blue-600 hover:bg-blue-700">
            {{ __('Add Bill') }}
        </x-button>
    </div>

    <!-- Search and Filter -->
    <div class="mb-4 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <x-input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="{{ __('Search students...') }}"
                class="w-full"
            />
        </div>
        <div class="sm:w-48">
            <x-select wire:model.live="statusFilter" class="w-full">
                <option value="">{{ __('All Status') }}</option>
                <option value="unpaid">{{ __('Unpaid') }}</option>
                <option value="paid">{{ __('Paid') }}</option>
            </x-select>
        </div>
    </div>

    <!-- Bills Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($bills as $bill)
            <div class="bg-blue-100 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg hover:shadow-2xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ substr($bill->user->name, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $bill->user->name }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    NIM: {{ $bill->user->nip }}
                                </div>
                               
                            </div>
                        </div>
                        @if($bill->status === 'paid')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                {{ __('Paid') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-red-500 text-white dark:bg-red-900 dark:text-red-200">
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

                    <div class="flex flex-wrap gap-2">
                        @if($bill->status === 'unpaid')
                            <x-button
                                wire:click="markAsPaid({{ $bill->id }})"
                                class="bg-green-600 hover:bg-green-700 text-xs px-3 py-2 flex-1"
                                wire:confirm="{{ __('Mark as Paid') }}?"
                            >
                                {{ __('Mark as Paid') }}
                            </x-button>
                        @endif
                        <x-button
                            wire:click="openEditModal({{ $bill->id }})"
                            class="bg-yellow-600 hover:bg-yellow-700 text-xs px-3 py-2 flex-1"
                        >
                            {{ __('Edit') }}
                        </x-button>
                        <x-danger-button
                            wire:click="deleteBill({{ $bill->id }})"
                            class="text-xs px-3 py-2 flex-1"
                            wire:confirm="{{ __('Delete Bill') }}?"
                        >
                            {{ __('Delete') }}
                        </x-danger-button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-500 dark:text-gray-400 text-lg">
                    {{ __('No bills found.') }}
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($bills->hasPages())
        <div class="mt-6 bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6 sm:rounded-lg">
            {{ $bills->links() }}
        </div>
    @endif

    <!-- Create Modal -->
    <x-dialog-modal wire:model="showCreateModal">
        <x-slot name="title">
            {{ __('Add Bill') }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="user_id" value="{{ __('Student') }}" />
                    <x-select wire:model="user_id" id="user_id" class="w-full">
                        <option value="">{{ __('Select Student') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->nip }})</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="user_id" />
                </div>

                <div>
                    <x-label for="description" value="{{ __('Description') }}" />
                    <x-textarea wire:model="description" id="description" class="w-full" rows="3" />
                    <x-input-error for="description" />
                </div>

                <div>
                    <x-label for="amount" value="{{ __('Amount') }}" />
                    <x-input wire:model="amount" id="amount" type="number" step="0.01" class="w-full" />
                    <x-input-error for="amount" />
                </div>

                <div>
                    <x-label for="status" value="{{ __('Status') }}" />
                    <x-select wire:model="status" id="status" class="w-full">
                        <option value="unpaid">{{ __('Unpaid') }}</option>
                        <option value="paid">{{ __('Paid') }}</option>
                    </x-select>
                    <x-input-error for="status" />
                </div>

                <div>
                    <x-label for="due_date" value="{{ __('Due Date') }}" />
                    <x-input wire:model="due_date" id="due_date" type="date" class="w-full" />
                    <x-input-error for="due_date" />
                </div>

                <div>
                    <x-label for="proof" value="{{ __('Proof of Transfer') }}" />
                    <x-input wire:model="proof" id="proof" type="file" class="w-full" accept="image/*,.pdf" />
                    <x-input-error for="proof" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeCreateModal">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button wire:click="createBill" class="ml-3">
                {{ __('Create') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Edit Modal -->
    <x-dialog-modal wire:model="showEditModal">
        <x-slot name="title">
            {{ __('Edit Bill') }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="edit_user_id" value="{{ __('Student') }}" />
                    <x-select wire:model="user_id" id="edit_user_id" class="w-full">
                        <option value="">{{ __('Select Student') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->nip }})</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="user_id" />
                </div>

                <div>
                    <x-label for="edit_description" value="{{ __('Description') }}" />
                    <x-textarea wire:model="description" id="edit_description" class="w-full" rows="3" />
                    <x-input-error for="description" />
                </div>

                <div>
                    <x-label for="edit_amount" value="{{ __('Amount') }}" />
                    <x-input wire:model="amount" id="edit_amount" type="number" step="0.01" class="w-full" />
                    <x-input-error for="amount" />
                </div>

                <div>
                    <x-label for="edit_status" value="{{ __('Status') }}" />
                    <x-select wire:model="status" id="edit_status" class="w-full">
                        <option value="unpaid">{{ __('Unpaid') }}</option>
                        <option value="paid">{{ __('Paid') }}</option>
                    </x-select>
                    <x-input-error for="status" />
                </div>

                <div>
                    <x-label for="edit_due_date" value="{{ __('Due Date') }}" />
                    <x-input wire:model="due_date" id="edit_due_date" type="date" class="w-full" />
                    <x-input-error for="due_date" />
                </div>

                <div>
                    <x-label for="edit_proof" value="{{ __('Proof of Transfer') }}" />
                    <x-input wire:model="proof" id="edit_proof" type="file" class="w-full" accept="image/*,.pdf" />
                    <x-input-error for="proof" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeEditModal">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button wire:click="updateBill" class="ml-3">
                {{ __('Update') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
