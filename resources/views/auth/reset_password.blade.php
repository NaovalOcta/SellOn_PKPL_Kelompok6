@extends('layouts.base_layout')

@section('title', 'Reset Kata Sandi')
@section('content')

<main class="w-full min-h-[73vh] flex items-center">
  <div class="w-full max-w-md mx-auto mt-12 p-6 bg-white rounded-lg shadow-md">
    <h2 class="mb-10 text-2xl font-semibold text-gray-800 text-center">
      Reset Kata Sandi
    </h2>

    @if (session('toast_error'))
      <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        {{ session('toast_error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ $email }}"> 

      <div id="email-form">
        <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
        <input id="email" name="email" type="email" 
          class="input-field cursor-not-allowed" 
          value="{{ $email }}" 
          placeholder="email@webmail.umm.ac.id" 
          autocomplete="email"
          required 
          disabled
        >
        @error('email')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>  
      <div id="password-form">
        <label class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
        <input id="password" name="password" type="password" 
          class="input-field" 
          placeholder="••••••••"
          autocomplete="new-password"
          required
        >
        @error('password')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div id="password-form">
        <label class="block text-sm font-medium text-slate-700 mb-1">Confirm New Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" 
          class="input-field" 
          placeholder="••••••••"
          autocomplete="new-password"
          required
        >
        @error('password')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>
      <button type="submit"
        class="w-full btn btn-primary">
        Reset Password
      </button>
      <a href="{{ route('login') }}" class="text-sm text-primary-600 hover:underline">
        Kembali ke login
      </a>
    </form>
  </div>
  </main>
  @endsection
