@extends('layouts.main')

@section('title', 'Edit Profile - ' . config('agency.seo.title_suffix') . '')

@section('content')
<main class="pt-24 pb-20 bg-gray-50 min-h-screen">
  <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900" style="letter-spacing:-0.02em">Edit Profile</h1>
      <p class="mt-1 text-gray-500">Update your account information</p>
    </div>

    {{-- Profile Form --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8 mb-6">
      <h2 class="text-lg font-semibold text-gray-900 mb-6">Profile Information</h2>

      @if(session('status') === 'profile-updated')
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-sm text-green-800">
          Profile updated successfully!
        </div>
      @endif

      <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700">Name *</label>
          <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 text-gray-900">
          @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700">Email *</label>
          <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 text-gray-900">
          @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit"
          class="inline-flex items-center justify-center rounded-md bg-primary text-primary-foreground hover:bg-primary/90 text-sm font-medium h-10 px-6">
          Save Changes
        </button>
      </form>
    </div>

    {{-- Password Form --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8 mb-6">
      <h2 class="text-lg font-semibold text-gray-900 mb-6">Change Password</h2>

      @if(session('status') === 'password-updated')
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-sm text-green-800">
          Password updated successfully!
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700">Current Password</label>
          <input type="password" name="current_password"
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 text-gray-900">
          @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700">New Password</label>
          <input type="password" name="password"
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 text-gray-900">
          @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input type="password" name="password_confirmation"
            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 text-gray-900">
        </div>

        <button type="submit"
          class="inline-flex items-center justify-center rounded-md bg-primary text-primary-foreground hover:bg-primary/90 text-sm font-medium h-10 px-6">
          Update Password
        </button>
      </form>
    </div>

    <a href="{{ route('client-dashboard.index') }}"
       class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
      Back to Dashboard
    </a>

  </div>
</main>
@endsection
