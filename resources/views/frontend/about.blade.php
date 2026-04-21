@extends('layouts.main')

@section('title', $page?->seo_title ?? 'About Us - ' . config('agency.seo.title_suffix'))
@section('description', $page?->seo_description ?? '')

@section('content')
<main class="pt-24 pb-20">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="text-center mb-12">
      <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="letter-spacing: -0.02em;">
        {{ $page?->hero_title ?? 'About Us' }}
      </h1>
      <p class="text-xl text-gray-600 leading-relaxed">
        {{ $page?->hero_subtitle ?? config('agency.full_name') . ' — Learn more about us' }}
      </p>
      @if($page?->hero_button_text && $page?->hero_button_url)
        <a href="{{ $page->hero_button_url }}"
           class="inline-flex items-center justify-center mt-6 rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-6 py-2">
          {{ $page->hero_button_text }}
        </a>
      @endif
    </div>

    {{-- Content --}}
    @if($page?->content)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8">
      <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed">
        {!! $page->content !!}
      </div>
    </div>
    @else
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8">
      <p class="text-gray-500 text-center">Content coming soon.</p>
    </div>
    @endif

  </div>
</main>
@endsection
