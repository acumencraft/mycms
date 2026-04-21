@extends('layouts.main')

@section('title', $page->seo_title ?? $page->title . ' - ' . config('agency.seo.title_suffix'))
@section('description', $page->seo_description ?? '')

@section('content')
<main class="pt-24 pb-20">
  @if($page->hero_title)
  <div class="bg-gradient-to-br from-primary/5 to-primary/10 py-16 mb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="letter-spacing: -0.02em;">
        {{ $page->hero_title }}
      </h1>
      @if($page->hero_subtitle)
      <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $page->hero_subtitle }}</p>
      @endif
    </div>
  </div>
  @else
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
    <h1 class="text-4xl font-bold text-gray-900" style="letter-spacing: -0.02em;">{{ $page->title }}</h1>
  </div>
  @endif

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    @if($page->content)
    <div class="prose max-w-none text-gray-600">
      {!! $page->content !!}
    </div>
    @endif
  </div>
</main>
@endsection
