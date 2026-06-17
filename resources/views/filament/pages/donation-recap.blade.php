<x-filament-panels::page>
  {{-- Step 1: Paste raw WhatsApp text --}}
  <div
    class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
  >
    <h3 class="mb-1 text-base font-semibold text-gray-950 dark:text-white">
      Tempel Pesan WhatsApp
    </h3>
    <p class="mb-4 text-sm text-gray-500">Tempel isi pesan dari grup WhatsApp. Sistem akan mendeteksi nama, jumlah, tanggal, dan metode secara otomatis.</p>

    <textarea
      wire:model="rawText"
      rows="10"
      placeholder="1. Uda Agusrial Aceh Rp. 50.000 1/6/26 (tfr)&#10;2. Uni Dewi Kurnia Putri Rp. 200.000&#10;3. Hamba Allah Kolok Mudiak Rp.100.000 2/6/26&#10;..."
      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 font-mono text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
    ></textarea>

    <div class="mt-4 flex items-center justify-between">
      <p class="text-xs text-gray-400">Format dikenali: nama &bull; Rp.jumlah &bull; tanggal (d/m/yy) &bull; (tfr) untuk transfer</p>
      <x-filament::button
        wire:click="parse"
        wire:loading.attr="disabled"
        icon="heroicon-m-sparkles"
      >
        <span wire:loading.remove wire:target="parse">Parse Teks</span>
        <span wire:loading wire:target="parse">Memproses...</span>
      </x-filament::button>
    </div>
  </div>

  {{-- Step 2: Review & edit parsed rows --}}
  @if (count($this->data['donations'] ?? []) > 0)
    <div class="mt-6">
      <div class="mb-4 flex items-center justify-between">
        <div>
          <h3 class="text-base font-semibold text-gray-950 dark:text-white">
            Hasil Parsing
          </h3>
          <p class="text-sm text-gray-500">Periksa dan perbaiki data sebelum menyimpan. Gunakan tombol hapus pada tiap baris jika ada data yang salah.</p>
        </div>
        <span
          class="rounded-full bg-primary-50 px-3 py-1 text-sm font-semibold text-primary-700 dark:bg-primary-900/30 dark:text-primary-400"
        >
          {{ count($this->data['donations']) }} donasi
        </span>
      </div>

      <form wire:submit="submitAll">
        {{ $this->form }}

        <div class="mt-6 flex justify-end">
          <x-filament::button
            type="submit"
            color="success"
            size="lg"
            icon="heroicon-m-check-circle"
            wire:loading.attr="disabled"
          >
            <span wire:loading.remove wire:target="submitAll">
              Simpan {{ count($this->data['donations']) }} Donasi ke Database
            </span>
            <span wire:loading wire:target="submitAll">Menyimpan...</span>
          </x-filament::button>
        </div>
      </form>
    </div>
  @endif
</x-filament-panels::page>
