@extends('layout.app')

@section('content')
  <div class="flex items-center justify-center translate-y-1/3">
    <div class="w-full max-w-md">
      <div class="bg-white rounded-2xl border border-green-700 shadow-lg shadow-green-100 p-8">

        <div class="flex justify-center mb-6">
          <img src="{{ asset('images/logo.png') }}" alt="Arrasyid Logo" class="h-20 w-auto" />
        </div>

        <h1 class="font-josefin-sans font-semibold text-2xl text-center text-gray-800 mb-1">
          Admin Login
        </h1>
        <p class="text-center text-sm text-gray-500 mb-8">RTQ Ar-Rasyid Sawah Lunto</p>

        @if ($errors->any())
          <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-6">
            {{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
          @csrf

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              id="email"
              type="email"
              name="email"
              value="{{ old('email') }}"
              required
              autofocus
              autocomplete="email"
              class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition text-sm"
              placeholder="admin@example.com"
            />
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
              id="password"
              type="password"
              name="password"
              required
              autocomplete="current-password"
              class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 transition text-sm"
              placeholder="••••••••"
            />
          </div>

          <div class="flex items-center gap-2">
            <input
              id="remember"
              type="checkbox"
              name="remember"
              class="rounded border-gray-300 text-green-500 focus:ring-green-300"
            />
            <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
          </div>

          <button
            type="submit"
            class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2.5 rounded-xl transition duration-200 text-sm"
          >
            Masuk
          </button>
        </form>

      </div>
    </div>
  </div>
@endsection
