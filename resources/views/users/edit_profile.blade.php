@extends('layouts.base_layout')

@section('title', 'Tambah Produk - SellOn')

@section('content')

{{-- 
VARIABLE:
$user = Array variable about all the data inside 'User' table
--}}
<main class="fade-in-effect w-auto mx-auto px-4 sm:px-6 py-8 min-h-[73vh] flex justify-center bg-brand-secondary">
  <div class="w-full max-w-3xl p-6 sm:p-8 gap-5 flex flex-col rounded-2xl shadow-sm border-2 border-slate-200 bg-white">
    {{-- BreadCrumb --}}
    <div class="border-b border-slate-100 pb-4">
      <h1 class="text-2xl font-display font-bold text-brand-main">Update Profile</h1>
      <p class="text-brand-muted text-sm mt-1">Update the details of your profile.</p>
    </div>
    {{-- Profile Data Section --}}
    <div class="gap-10 flex flex-col items-center ">
      {{-- Profile Image --}}
      <div class="w-40 h-40 bg-slate-100 rounded-full overflow-hidden border-4 border-brand-accent shrink-0 shadow-md">
        <img 
          src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($user->name) }}" 
          alt="Avatar"
          class="w-full h-full object-cover"
        >
      </div>
      {{-- Profile Data Form --}}
      <form id="form-profile" 
        action="{{ route('users.update_profile', ['id' => $user->id]) }}" 
        method="POST" 
        enctype="multipart/form-data"
        class="w-full"  
      >
        @csrf 
        @method('PUT')
        <div class="mb-6">
          <label class="block text-sm font-semibold text-brand-main mb-2">
            Full Name 
            <span class="text-red-500">*</span>
          </label>
          <input 
            type="text" 
            id="name" 
            name="name"  
            placeholder="John Wayne" 
            value="{{ $user->name }}"
            class="input-field"
            required
          >
          <span id="err-name" class="text-xs text-red-500 hidden mt-1"></span>
        </div>

        <div class="space-y-6 grid grid-cols-1 sm:grid-cols-2 gap-10">
          <div>
            <label class="block text-sm font-semibold text-brand-main mb-2">
              NIM 
              <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              id="nim" 
              name="nim" 
              placeholder="201210370311187" 
              value="{{ $user->nim }}"
              class="input-field"
              required
            >
            <span id="err-nim" class="text-xs text-red-500 hidden mt-1"></span>
          </div>

          <div>
            <label class="block text-sm font-semibold text-brand-main mb-2">
              Major 
              <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              id="major" 
              name="major" 
              placeholder="Informatic" 
              value="{{ $user->major }}"
              class="input-field"
              required>
            <span id="err-major" class="text-xs text-red-500 hidden mt-1"></span>
          </div>
        </div>

        <div class="space-y-6 grid grid-cols-1 sm:grid-cols-2 gap-10">
          <div>
            <label class="block text-sm font-semibold text-brand-main mb-2">
              Email 
              <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              id="email" 
              name="email" 
              placeholder="[EMAIL_ADDRESS]" 
              value="{{ $user->email }}"
              class="input-field"              
              required
            >
            <span id="err-email" class="text-xs text-red-500 hidden mt-1"></span>
          </div>

          <div>
            <label class="block text-sm font-semibold text-brand-main mb-2">
              WhatsApp Number
              <span class="text-red-500">*</span>
            </label>
            <input 
              type="text" 
              id="whatsapp_no" 
              name="whatsapp_no" 
              placeholder="08123456789" 
              value="{{ $user->whatsapp_no }}"
              class="input-field"
              required
            >
            <span id="err-whatsapp-no" class="text-xs text-red-500 hidden mt-1"></span>
          </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-slate-100">
          <button type="submit" class="btn btn-primary w-full sm:w-auto gap-2">
            Save Profile
          </button>
        </div>
      </form>
    </div>
  </div>
</main>

@vite('resources/js/profile/edit_profile_js.js')

@endsection