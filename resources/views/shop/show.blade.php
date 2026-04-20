@extends('layouts.main')

@section('title', $product->name . ' - ' . config('agency.seo.title_suffix'))
@section('description', $product->short_description ?? $product->name)

@section('content')
<main class="pt-24 pb-20">

  {{-- Flash Messages --}}
  @if(session('success'))
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl px-6 py-4 flex items-center gap-3">
      <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
      </svg>
      {{ session('success') }}
    </div>
  </div>
  @endif
  @if(session('error'))
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl px-6 py-4">
      {{ session('error') }}
    </div>
  </div>
  @endif

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

      {{-- LEFT: Images --}}
      <div class="space-y-4">
        {{-- Main Image --}}
        @if($product->image)
          <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
               class="w-full h-80 object-cover rounded-xl shadow-md">
        @else
          <div class="w-full h-80 bg-gradient-to-br from-primary/20 to-primary/5 rounded-xl flex items-center justify-center">
            <svg class="w-20 h-20 text-primary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
          </div>
        @endif

        {{-- Gallery --}}
        @if($product->gallery_images && count($product->gallery_images) > 0)
        <div class="grid grid-cols-3 gap-3">
          @foreach($product->gallery_images as $image)
          <img src="{{ asset('storage/'.$image) }}" alt="{{ $product->name }}"
               class="w-full h-24 object-cover rounded-lg shadow-sm cursor-pointer hover:opacity-90 transition-opacity">
          @endforeach
        </div>
        @endif
      </div>

      {{-- RIGHT: Details --}}
      <div>
        <span class="text-xs font-medium text-primary uppercase tracking-wide">
          {{ ucwords(str_replace('-', ' ', $product->category)) }}
        </span>

        <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-4">
          {{ $product->name }}
        </h1>

        @if($product->short_description)
        <p class="text-gray-600 leading-relaxed mb-6">
          {{ $product->short_description }}
        </p>
        @endif

        {{-- Price --}}
        <div class="mb-6">
          <span class="text-4xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
        </div>

        {{-- Version --}}
        @if($product->versions->count())
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
          <p class="text-sm text-gray-500">
            Latest version:
            <span class="font-medium text-gray-900">{{ $product->versions->first()->version_number }}</span>
          </p>
        </div>
        @endif

        {{-- Action Buttons --}}
        <div class="flex flex-wrap gap-3 mb-8">
          @if($hasPurchased)
            @php
              $activePurchase = \App\Models\Purchase::where('user_id', auth()->id())
                ->whereHas('version', fn($q) => $q->where('digital_product_id', $product->id))
                ->latest()->first();
            @endphp
            @if($activePurchase)
            <a href="{{ route('purchase.download', $activePurchase) }}"
               class="inline-flex items-center gap-2 bg-green-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-green-700 transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
              </svg>
              Download
            </a>
            @endif
          @else
            @auth
              <a href="{{ route('shop.checkout', $product->slug) }}"
                 class="inline-flex items-center gap-2 bg-primary text-white px-8 py-3 rounded-lg font-medium hover:bg-primary/90 transition-colors">
                Buy Now — ${{ number_format($product->price, 2) }}
              </a>
            @else
              <a href="{{ route('login') }}"
                 class="inline-flex items-center gap-2 bg-primary text-white px-8 py-3 rounded-lg font-medium hover:bg-primary/90 transition-colors">
                Login to Purchase
              </a>
            @endauth
          @endif

          @if($product->demo_url)
          <a href="{{ $product->demo_url }}" target="_blank"
             class="inline-flex items-center gap-2 border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-medium hover:border-primary hover:text-primary transition-colors">
            Live Demo
          </a>
          @endif
        </div>

        {{-- Tags --}}
        @if($product->tags && count($product->tags) > 0)
        <div class="flex flex-wrap gap-2">
          @foreach($product->tags as $tag)
          <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">{{ $tag }}</span>
          @endforeach
        </div>
        @endif
      </div>
    </div>

    {{-- Description --}}
    @if($product->description)
    <div class="mt-16 border-t border-gray-100 pt-12">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Description</h2>
      <div class="prose max-w-none text-gray-600">
        {!! $product->description !!}
      </div>
    </div>
    @endif

  </div>
</main>
@endsection
