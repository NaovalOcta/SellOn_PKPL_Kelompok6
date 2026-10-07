@extends('layouts.base_layout')

@section('title', 'Lupa Kata Sandi')
@section('content')

<main class="w-full min-h-[73vh] flex items-center">
  <div class="w-full max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="mb-10 text-2xl font-semibold text-gray-800 text-center">
      Forgot Password?
    </h2>

    @if (session('toast_success'))
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('toast_success') }}
      </div>
    @endif

    @if (session('toast_error'))
      <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        {{ session('toast_error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
      @csrf
      <div>
        <div id="email-form">
          <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
          <input id="email" name="email" type="email" 
            class="input-field" 
            value="{{ old('email') }}" 
            placeholder="email@webmail.umm.ac.id" 
            required 
            autocomplete="email"
          >
          @error('email')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
          @enderror
        </div>  
      </div>
      <button type="submit" class="w-full btn btn-primary">Verifikasi Email</button>
      <a href="{{ route('login') }}" class="text-sm text-primary-600 hover:underline">
        Kembali ke login
      </a>
    </form>
    </div>
</main>
@endsection
