<nav class="mb-6 w-full sticky">
  <div class="max-w-xl mx-auto w-full relative">
    <div class="bg-white rounded-full w-fit absolute -top-4 -translate-x-full -left-2 p-2">
      <img src="{{ asset('images/logo.png') }}" alt="Arrasyid Logo" class="h-18 w-auto">
    </div>
    <ul class="flex items-center justify-between bg-white px-12 py-4 rounded-full border border-green-500 text-lg font-semibold min-h-12">
      <li class="leading-none">
        <a href="{{ url('/') }}" class="text-[#1b1b18] hover:text-[#1b1b18] hover:underline">Tentang Kami</a>
      </li>
      <li class="leading-none">
        <a href="{{ route('donations.index') }}" class="text-[#1b1b18] hover:text-[#1b1b18] hover:underline">Laporan Kegiatan</a>
      </li>
      <li class="leading-none">
        <a href="{{ route('activities.index') }}" class="text-[#1b1b18] hover:text-[#1b1b18] hover:underline">Donasi</a>
      </li>
      @auth
      <li>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="text-[#1b1b18] hover:text-[#1b1b18]">Logout</button>
        </form>  
      </li>
      @endauth
    </ul>
  </div>
</nav>
