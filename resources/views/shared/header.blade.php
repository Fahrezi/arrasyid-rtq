<nav class="mb-6 w-full sticky top-8 z-50">
  <div class="max-w-xl mx-auto w-full relative">
    <div
      class="bg-white rounded-full w-fit absolute -top-4 -translate-x-full -left-2 p-2 hidden sm:block shadow-lg shadow-green-300/30"
    >
      <img
        src="{{ asset('images/logo.png') }}"
        alt="Arrasyid Logo"
        class="h-18 w-auto"
      />
    </div>

    {{-- Desktop nav --}}
    <ul
      class="hidden sm:flex items-center justify-between bg-white px-12 py-4 rounded-full border border-green-500 shadow-lg shadow-green-300/30 text-lg font-semibold min-h-12"
    >
      <li class="leading-none">
        <a
          href="#about-us"
          class="text-[#1b1b18] hover:text-[#1b1b18] hover:underline"
          >Tentang Kami</a
        >
      </li>
      <li class="leading-none">
        <a
          href="#activities"
          class="text-[#1b1b18] hover:text-[#1b1b18] hover:underline"
          >Laporan Kegiatan</a
        >
      </li>
      <li class="leading-none">
        <a
          href="#donate"
          class="text-[#1b1b18] hover:text-[#1b1b18] hover:underline"
          >Donasi</a
        >
      </li>
      @auth
        <li class="leading-none">
          <a href="{{ route('filament.admin.pages.dashboard') }}" class="text-[#1b1b18] hover:text-[#1b1b18] hover:underline">
            Dashboard
          </a>
        </li>
      @endauth
    </ul>

    {{-- Mobile nav bar --}}
    <div
      class="flex sm:hidden items-center justify-between bg-white px-4 py-3 border border-green-500 rounded-full"
    >
      <img
        src="{{ asset('images/logo.png') }}"
        alt="Arrasyid Logo"
        class="h-10 w-auto"
      />
      <button
        id="hamburger-btn"
        aria-label="Toggle menu"
        class="p-2 rounded-lg hover:bg-green-50 transition-colors"
      >
        <svg id="icon-hamburger" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    {{-- Mobile menu dropdown --}}
    <div
      id="mobile-menu"
      class="hidden sm:hidden mt-2 bg-[linear-gradient(180deg,#DBFFDB_0%,#F4FFF4_50%)] backdrop-blur-md border border-green-400 rounded-2xl overflow-hidden shadow-lg shadow-green-200/50"
    >
      <a
        href="#about-us"
        class="block px-6 py-4 text-base font-semibold text-green-900 hover:bg-green-300/30 border-b border-green-300/50 transition-colors"
      >
        Tentang Kami
      </a>
      <a
        href="#activities"
        class="block px-6 py-4 text-base font-semibold text-green-900 hover:bg-green-300/30 border-b border-green-300/50 transition-colors"
      >
        Laporan Kegiatan
      </a>
      <a
        href="#donate"
        class="block px-6 py-4 text-base font-semibold text-green-900 hover:bg-green-300/30 transition-colors @auth border-b border-green-300/50 @endauth"
      >
        Donasi
      </a>
      @auth
        <a
          href="{{ route('filament.admin.pages.dashboard') }}"
          class="block px-6 py-4 text-base font-semibold text-green-900 hover:bg-green-300/30 transition-colors"
        >
          Dashboard
        </a>
      @endauth
    </div>
  </div>
</nav>

<script>
  const btn = document.getElementById("hamburger-btn");
  const menu = document.getElementById("mobile-menu");
  const iconOpen = document.getElementById("icon-hamburger");
  const iconClose = document.getElementById("icon-close");

  btn.addEventListener("click", () => {
    const isOpen = !menu.classList.contains("hidden");
    menu.classList.toggle("hidden", isOpen);
    iconOpen.classList.toggle("hidden", !isOpen);
    iconClose.classList.toggle("hidden", isOpen);
  });
</script>
