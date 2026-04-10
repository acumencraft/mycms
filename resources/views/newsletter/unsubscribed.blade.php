@extends('layouts.main')
@section('title', 'Unsubscribed — ' . config('agency.seo.title_suffix') . '')
@section('content')
<main class="pt-24 pb-20 bg-gray-50 min-h-screen flex items-center justify-center">
  <div class="max-w-md mx-auto text-center px-4">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10">
      <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
      </div>
      <h1 class="text-2xl font-bold text-gray-900 mb-2">Unsubscribed</h1>
      <p class="text-gray-500 mb-6">
        <strong>{{ $subscriber->email }}</strong> has been successfully removed from our newsletter.
      </p>
      <a href="{{ route('home') }}"
         class="inline-flex items-center justify-center rounded-md bg-primary text-primary-foreground hover:bg-primary/90 text-sm font-medium h-10 px-6">
        Back to Homepage
      </a>
    </div>
  </div>
</main>
@endsection
