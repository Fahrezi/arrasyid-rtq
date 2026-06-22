@extends('layout.app')

@section('content')
  <div class="max-w-7xl mx-auto px-2 sm:px-6 py-16 sm:py-24">
    <div class="max-w-md mx-auto text-center">

      @if ($success)
        {{-- Success --}}
        <div class="flex items-center justify-center w-20 h-20 mx-auto mb-6 rounded-full bg-green-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
          </svg>
        </div>
        <h1 class="font-josefin-sans font-bold text-3xl text-gray-800 mb-3">Jazakallahu Khairan!</h1>
        <p class="text-gray-500 mb-6 leading-relaxed">
          Donasi Anda telah berhasil. Semoga menjadi amal jariyah yang terus mengalir.<br>
          Terima kasih telah mendukung RTQ Ar-Rasyid.
        </p>
      @else
        {{-- Failed / Pending --}}
        <div class="flex items-center justify-center w-20 h-20 mx-auto mb-6 rounded-full bg-red-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </div>
        <h1 class="font-josefin-sans font-bold text-3xl text-gray-800 mb-3">Pembayaran Belum Selesai</h1>
        <p class="text-gray-500 mb-6 leading-relaxed">
          Pembayaran tidak berhasil atau dibatalkan. Silakan coba lagi atau pilih metode lain.
        </p>
      @endif

      @if ($payment)
        <div class="bg-gray-50 rounded-2xl p-5 text-left text-sm mb-8 space-y-2 border border-gray-100">
          <div class="flex justify-between">
            <span class="text-gray-500">Order ID</span>
            <span class="font-medium text-gray-800 font-mono text-xs">{{ $payment->merchant_order_id }}</span>
          </div>
          @if ($reference)
            <div class="flex justify-between">
              <span class="text-gray-500">Referensi</span>
              <span class="font-medium text-gray-800 font-mono text-xs">{{ $reference }}</span>
            </div>
          @endif
          <div class="flex justify-between">
            <span class="text-gray-500">Jumlah</span>
            <span class="font-medium text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
          </div>
          @if ($payment->donation?->donor)
            <div class="flex justify-between">
              <span class="text-gray-500">Nama</span>
              <span class="font-medium text-gray-800">{{ $payment->donation->donor->name }}</span>
            </div>
          @endif
        </div>
      @endif

      <a href="{{ url('/') }}"
        class="inline-block px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-full transition duration-200">
        Kembali ke Beranda
      </a>
    </div>
  </div>
@endsection
