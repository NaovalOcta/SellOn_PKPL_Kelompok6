@extends('layouts.base_layout')

@section('title', 'Daftar Akun - SellOn')

@section('content')

<main class="fade-in-effect min-h-[73vh] max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex justify-center items-center">
  <div id="register-view" class="view-section w-full max-w-md md:max-w-4xl flex flex-col md:flex-row justify-center items-stretch mt-4 md:mt-10">
    <div class="w-full md:w-1/3 p-8 md:p-10 gap-y-5 flex flex-col justify-center items-center rounded-t-2xl md:rounded-tr-none md:rounded-l-2xl bg-brand-main text-center">
      <h2 class="text-3xl font-display font-bold text-white mb-2">Register SellOn Account</h2>
      <p class="text-brand-muted text-sm">Join the campus marketplace ecosystem.</p>
    </div>

    <div class="w-full md:w-2/3 p-8 md:p-10 rounded-b-2xl md:rounded-bl-none md:rounded-r-2xl border-stone-300 border-2 border-t-0 md:border-t-2 md:border-l-0 bg-stone-100">
      <form id="form-register" action="{{ route('register_post') }}" method="POST">
        @csrf
        <div class="mb-4">
          <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
          <input 
            type="text" 
            id="name" 
            name="name" 
            class="input-field" 
            placeholder="Nama sesuai KTM" 
            required
          >
          <span id="err-name" class="text-xs text-red-500 hidden mt-1"></span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">NIM</label>
            <input
              type="text"
              id="nim"
              name="nim"
              class="input-field"
              placeholder="15 Digit NIM"
              maxlength="15"
            >
            <span id="err-nim" class="text-xs text-red-500 hidden mt-1"></span>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Major</label>
            <input 
              type="text" 
              id="major" 
              name="major" 
              class="input-field" 
              placeholder="Major" 
              required
            >
            <span id="err-major" class="text-xs text-red-500 hidden mt-1"></span>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              class="input-field" 
              placeholder="email@webmail.umm.ac.id" 
              required
            >
            <span id="err-email" class="text-xs text-red-500 hidden mt-1"></span>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">No WhatsApp</label>
            <input 
              type="tel" 
              id="whatsapp_no" 
              name="whatsapp_no" 
              class="input-field" 
              placeholder="08xxxxxxxxx"
            >
            <span id="err-whatsapp-no" class="text-xs text-red-500 hidden mt-1"></span>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input 
              type="password" 
              id="password" 
              name="password" 
              class="input-field" 
              placeholder="••••••••" 
              required
            >
            <span id="err-password" class="text-xs text-red-500 hidden mt-1"></span>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
            <input 
              type="password" 
              id="password_confirmation" 
              name="password_confirmation" 
              class="input-field" 
              placeholder="••••••••" 
              required
            >
            <span id="err-password-conf" class="text-xs text-red-500 hidden mt-1"></span>
          </div>
        </div>
        <button type="submit" class="btn btn-primary w-full">Register</button>
      </form>

      {{-- Info verifikasi email --}}
      <div class="flex items-start gap-x-2 bg-teal-50 border border-teal-200 rounded-lg px-4 py-3 mt-4">
        <i class="fa-solid fa-envelope-circle-check text-brand-accent text-sm mt-0.5 flex-shrink-0"></i>
        <p class="text-xs text-teal-700">
          Setelah mendaftar, 
          <strong>link verifikasi</strong> 
          akan dikirim ke email kampus Anda. Akun baru dapat diaktifkan setelah verifikasi selesai.
        </p>
      </div>

      <p class="text-center text-sm text-brand-muted mt-6">
        Already have an account? 
        <a
          href="{{ route('login') }}"
          class="text-brand-accent font-medium inline-block hover:underline"
        >
          Login here
        </a>
      </p>
    </div>
  </div>
</main>

@vite('resources/js/auth/register_js.js')

@endsection
