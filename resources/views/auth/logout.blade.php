<x-guest-layout>
  <x-authentication-card>
    <x-slot name="logo">
      <x-authentication-card-logo />
    </x-slot>

    <div class="mb-4 text-sm text-white dark:text-gray-400">
      {{ __('Apakah Anda yakin ingin keluar?') }}
    </div>

    <form method="POST" action="{{ route('logout') }}">
      @csrf

      <div class="flex items-center justify-end">
        <a href="{{ url()->previous() }}">
          <x-secondary-button class="ms-4" type="button">
            {{ __('Batal') }}
          </x-secondary-button>
        </a>

        <x-button class="ms-4">
          {{ __('Keluar') }}
        </x-button>
      </div>
    </form>
  </x-authentication-card>
</x-guest-layout>
