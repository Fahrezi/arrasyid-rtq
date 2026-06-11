<nav class="mb-6 w-full sticky">
  <div class="bg-white rounded-full w-fit absolute -top-4 left-4 transform p-2">
    <img src="{{ asset('images/logo.png') }}" alt="Arrasyid Logo" class="h-18 w-auto">
  </div>
  <ul class="flex items-center justify-between text-lg font-semibold w-full max-w-xl mx-auto min-h-12">
    <li>
      <a href="{{ url('/') }}" class="text-[#1b1b18] hover:text-[#1b1b18] hover:underline">Tentang Kami</a>
    </li>
    <li>
      <a href="{{ route('donations.index') }}" class="text-[#1b1b18] hover:text-[#1b1b18] hover:underline">Laporan Kegiatan</a>
    </li>
    <li>
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
</nav>
