@extends('layouts.main')
@section('title', $guide->title . ' - ' . config('agency.name') . ' Guides')
@section('description', 'Guide: ' . $guide->title)

@section('content')
<main class="pt-24 pb-20">
  <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <header class="mb-10 text-center">
      @if($guide->category)
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-primary mb-4">
          {{ $guide->category->name }}
        </span>
      @endif
      <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight" style="letter-spacing: -0.02em;">
        {{ $guide->title }}
      </h1>
      @if($guide->published_at)
        <p class="text-sm text-gray-400">{{ $guide->published_at->format('M j, Y') }}</p>
      @endif
    </header>

    {{-- YouTube Video --}}
    @if($guide->youtube_embed)
    <div class="mb-10 rounded-xl overflow-hidden shadow-lg aspect-video">
      <iframe
        src="{{ $guide->youtube_embed }}"
        class="w-full h-full"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen>
      </iframe>
    </div>
    {{-- Cover Image (თუ YouTube არ არის) --}}
    @elseif($guide->cover_image)
    <div class="mb-10 rounded-xl overflow-hidden shadow-lg">
      <img src="{{ asset('storage/'.$guide->cover_image) }}" alt="{{ $guide->title }}"
           class="w-full h-64 object-cover">
    </div>
    @endif

    {{-- Content --}}
    <div class="prose prose-lg prose-gray max-w-none mb-12">
      {!! $guide->content !!}
    </div>

    {{-- Back --}}
    <div class="text-center">
      <a href="{{ route('guides') }}"
         class="inline-flex items-center px-6 py-3 text-base font-medium rounded-md text-white bg-primary hover:bg-primary/90 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Guides
      </a>
    </div>

  </article>
</main>
@endsection
