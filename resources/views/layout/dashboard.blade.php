<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap");
  </style>
  <title>Dashboard — {{ config('app.name', 'Arrasyid') }}</title>
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
</head>
<body class="min-h-screen bg-gray-100 text-gray-800 font-sans">

  <div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col shrink-0">
      <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-200">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto" />
        <div class="leading-tight">
          <p class="font-josefin-sans font-bold text-green-700 text-sm leading-none">RTQ Ar-Rasyid</p>
          <p class="text-xs text-gray-400 mt-0.5">Admin Panel</p>
        </div>
      </div>

      <nav class="flex-1 py-4 px-3 space-y-1">
        <a
          href="{{ route('dashboard') }}"
          class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
            {{ request()->routeIs('dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-100' }}"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          Dashboard
        </a>
      </nav>

      <div class="px-3 py-4 border-t border-gray-200">
        <div class="px-3 mb-3">
          <p class="text-xs text-gray-400">Masuk sebagai</p>
          <p class="text-sm font-medium text-gray-700 truncate">{{ Auth::user()->name }}</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button
            type="submit"
            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Logout
          </button>
        </form>
      </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col min-w-0">
      <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
        <h1 class="font-josefin-sans font-semibold text-lg text-gray-800">@yield('page-title', 'Dashboard')</h1>
        <span class="text-xs text-gray-400">RTQ Ar-Rasyid Admin</span>
      </header>

      <main class="flex-1 p-8">
        @yield('content')
      </main>
    </div>

  </div>

</body>
</html>
