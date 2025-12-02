<div class="p-6 lg:p-8 bg-blue-200">
  <script src="{{ url('/assets/js/qrcode.min.js') }}"></script>
  <x-button class="mb-4 mr-2" href="{{ route('admin.barcodes.create') }}">
    Buat Barcode Baru
  </x-button>
  <x-secondary-button class="mb-4">
    <a href="{{ route('admin.barcodes.downloadall') }}">Download Semua</a>
  </x-secondary-button>
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    @foreach ($barcodes as $barcode)
      @php
        $validityDuration = 10 * 60; // 10 minutes in seconds
        $createdAtIso = $barcode->created_at ? $barcode->created_at->toIso8601String() : null;
      @endphp
      <div
        x-data="{
          validityDuration: {{ $validityDuration }},
          createdAt: '{{ $createdAtIso }}',
          remaining: 0,
          intervalId: null,
          qrValue: '{{ $barcode->value }}',
          updateRemaining() {
            const createdTime = new Date(this.createdAt).getTime();
            const now = new Date().getTime();
            const expireTime = createdTime + this.validityDuration * 1000;
            this.remaining = Math.max(0, Math.floor((expireTime - now) / 1000));
          },
          startCountdown() {
            this.updateRemaining();
            this.intervalId = setInterval(() => {
              this.updateRemaining();
              if (this.remaining <= 0) {
                clearInterval(this.intervalId);
              }
            }, 1000);
          },
          generateQRCode() {
            if (!this.qrValue) {
              console.error('Empty QR code value for barcode ID: {{ $barcode->id }}');
              return;
            }
            let el = this.$refs.qrcodeContainer;
            el.innerHTML = '';
            new QRCode(el, {
              text: this.qrValue,
              colorDark: $store.darkMode.on ? '#ffffff' : '#000000',
              colorLight: $store.darkMode.on ? '#000000' : '#ffffff',
              correctLevel: QRCode.CorrectLevel.M,
              width: 256,
              height: 256,
            });
          }
        }"
        x-init="
          generateQRCode();
          startCountdown();
          $watch('$store.darkMode.on', value => generateQRCode());
        "
        class="flex flex-col rounded-lg bg-blue-100 p-4 shadow hover:bg-gray-500 dark:bg-gray-800 dark:shadow-gray-600 hover:dark:bg-gray-700"
      >
        <div class="mt-4 flex items-center justify-center gap-2">
          <x-secondary-button href="{{ route('admin.barcodes.download', $barcode->id) }}">
            Download
          </x-secondary-button>
          <x-button href="{{ route('admin.barcodes.edit', $barcode->id) }}">
            Edit
          </x-button>
          <x-danger-button wire:click="confirmDeletion({{ $barcode->id }}, '{{ $barcode->name }}')">
            Delete
          </x-danger-button>
        </div>
        <div class="container flex items-center justify-center p-4">
          <div x-ref="qrcodeContainer" class="h-64 w-64 bg-transparent"></div>
        </div>

        <!-- Countdown Timer Display -->
        <div class="text-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" x-text="
          remaining > 0
            ? 'QR Code valid for ' + Math.floor(remaining / 60) + 'm ' + (remaining % 60) + 's'
            : 'QR Code expired'"></div>

        <h3 class="mb-3 text-center text-lg font-semibold leading-tight text-gray-800 dark:text-white">
          {{ $barcode->name }}
        </h3>
        <ul class="list-disc pl-4 dark:text-gray-400">
          <li>
            <a href="https://www.google.com/maps/search/?api=1&query={{ $barcode->latitude }},{{ $barcode->longitude }}"
              target="_blank" class="hover:text-blue-500 hover:underline">
              {{ __('Coords') . ': ' . $barcode->latitude . ', ' . $barcode->longitude }}
            </a>
          </li>
          <li> {{ __('Radius (meter)') }}: {{ $barcode->radius }}</li>
        </ul>
      </div>
    @endforeach
  </div>

  <x-confirmation-modal wire:model="confirmingDeletion">
    <x-slot name="title">
      Hapus Barcode
    </x-slot>

    <x-slot name="content">
      Apakah Anda yakin ingin menghapus <b>{{ $deleteName }}</b>?
    </x-slot>

    <x-slot name="footer">
      <x-secondary-button wire:click="$toggle('confirmingDeletion')" wire:loading.attr="disabled">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
        {{ __('Confirm') }}
      </x-danger-button>
    </x-slot>
  </x-confirmation-modal>
</div>
