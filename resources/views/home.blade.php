@extends('layout.app')

@section('content')
  <div class="max-w-7xl mx-auto">
    <section class="flex flex-col items-center text-center justify-center bg-[#f4fff4] bg-[linear-gradient(180deg,#DBFFDB_0%,#F4FFF4_100%)] rounded-2xl border border-green-500 p-12 pt-16 min-h-[50vh] mt-12 relative">
      <span class="absolute inline-block top-0 left-1/2 -translate-x-1/2 bg-green-500 rounded-b-2xl py-4 px-8 text-2xl font-josefin-sans font-semibold text-white border-r border-b border-l border-green-500 shadow-lg shadow-green-500/50 uppercase text-nowrap">
        Rumah Tahfidz Al-Qur’an Ar-Rasyid Sawah Lunto
      </span>
      <h1 class="font-josefin-sans font-semibold text-5xl leading-20 max-w-9/12 mx-auto">Patungan Kebaikan, Tumbuh Bersama Cetak Generasi Qur'ani</h1>
      <p class="text-xl mt-4">Rumah Tahfidz Al-Qur’an Ar-Rasyid Sawah Lunto hadir sebagai wadah pencetak hafidz yang amanah. Salurkan donasi Anda dan pantau penyaluran dana secara terbuka, jujur, serta real-time kapan saja.</p>
      <a href="{{ route('activities.index') }}" class="mt-12 px-6 py-3 bg-green-500 text-white text-xl font-semibold rounded-full hover:bg-green-600 hover:outline-2 hover:outline-emerald-400 transition ease-in duration-200">Donasi Sekarang</a>
    </section>
    <h2 class="uppercase text-2xl font-semibold text-center mt-8 sm:mt-20 mb-8 sm:mb-12 font-josefin-sans">Tentang Kami</h2>
    <section class="flex flex-col sm:flex-row sm:items-center justify-between mb-12">
      <div class="space-y-4 max-w-6/12">
        <h2 class="text-4xl font-semibold leading-14">Menjaga Kalam-Mu, Mencetak Generasi Qur'ani di Pelosok Negeri</h2>
        <p class="leading-8">
          Rumah Tahfidz Al-Qur’an (RTQ) Ar-Rasyid adalah lembaga pendidikan non-profit di Sawah Lunto, Sumatera Barat, yang mendedikasikan diri untuk mencetak generasi penjaga Al-Qur'an secara gratis bagi anak-anak dan santri dhuafa. Kami memadukan metode hafalan yang kokoh dengan penanaman akhlak mulia sejak dini.
        <p class="leading-8">
          Sebagai wujud tanggung jawab mutlak kepada umat, kami mengutamakan transparansi dan akuntabilitas. Melalui platform ini, setiap rupiah donasi yang Anda titipkan akan tercatat secara real-time dan dilaporkan penyalurannya secara terbuka. Bersama RTQ Ar-Rasyid, mari alirkan kebaikan yang bersih, amanah, dan berdampak nyata bagi masa depan santri.
        </p>
      </div>
      <img class="rounded-xl max-w-5/12 h-auto" src="{{ asset('images/tentang-kami.jpg') }}" alt="Tentang Kami" class="mt-8 sm:mt-0" />
    </section>
  </div>
@endsection
