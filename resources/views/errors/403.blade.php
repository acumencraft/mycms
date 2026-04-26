@extends('layouts.main')
@section('title', '403 — Access Denied')
@section('content')
<main class="pt-24 pb-20 bg-gray-50 min-h-screen">
  <div class="max-w-lg mx-auto px-4 text-center">
    <div class="text-8xl font-bold text-gray-200 mb-4">403</div>
    <h1 class="text-2xl font-bold text-gray-900 mb-3">Access denied</h1>
    <p class="text-gray-500 mb-8">You do not have permission to view this page.</p>
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-xl transition-colors">
      Back to Home
    </a>
  </div>
</main>
@endsection
