@extends('layouts.main')
@section('title', 'Verify Email - ' . config('agency.seo.title_suffix'))
@section('content')
<main class="pt-24 pb-20 bg-gray-50 min-h-screen">
  <div class="max-w-md mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
      
      <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
      </div>

      <h1 class="text-2xl font-bold text-gray-900 mb-2">Verify your email</h1>
      <p class="text-gray-500 text-sm mb-6">
        We sent a verification link to your email address. Please check your inbox and click the link to activate your account.
      </p>

      @if (session('status') == 'verification-link-sent')
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-3">
          <p class="text-sm text-green-700 font-medium">A new verification link has been sent to your email.</p>
        </div>
      @endif

      <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
        @csrf
        <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-xl transition-colors">
          Resend Verification Email
        </button>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-gray-400 hover:text-gray-600 underline">
          Log Out
        </button>
      </form>

    </div>
  </div>
</main>
@endsection
