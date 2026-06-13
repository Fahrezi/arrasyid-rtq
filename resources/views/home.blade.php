@extends('layout.app')

@section('content')
  <div class="flex flex-col items-center text-center justify-center bg-[#f4fff4] bg-[linear-gradient(180deg,#DBFFDB_0%,#F4FFF4_100%)] rounded-2xl border border-green-500 p-12 pt-16 min-h-[50vh] mt-12 relative">
    <span class="absolute inline-block top-0 left-1/2 -translate-x-1/2 bg-green-500 rounded-b-2xl py-4 px-8 text-2xl font-josefin-sans font-semibold text-white border-r border-b border-l border-green-500 shadow-lg shadow-green-500/50 uppercase text-nowrap">
      Rumah Tahfidz Al-Qur’an Ar-Rasyid Sawah Lunto
    </span>
    <h1 class="font-josefin-sans font-semibold text-5xl leading-20 max-w-9/12 mx-auto">Patungan Kebaikan, Tumbuh Bersama Cetak Generasi Qur'ani</h1>
    <p class="text-xl mt-4">Rumah Tahfidz Al-Qur’an Ar-Rasyid Sawah Lunto hadir sebagai wadah pencetak hafidz yang amanah. Salurkan donasi Anda dan pantau penyaluran dana secara terbuka, jujur, serta real-time kapan saja.</p>
    <a href="{{ route('activities.index') }}" class="mt-12 px-6 py-3 bg-green-500 text-white text-xl font-semibold rounded-full hover:bg-green-600 hover:outline-2 hover:outline-emerald-400 transition transition ease-in duration-200">Donasi Sekarang</a>
  </div>
@endsection