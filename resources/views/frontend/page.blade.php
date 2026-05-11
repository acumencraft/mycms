@extends('layouts.main')
@section('title', $page->seo_title ?? ($page->page_title ?? $page->title) . ' - ' . config('agency.seo.title_suffix'))
@section('description', $page->seo_description ?? '')
@section('content')
<main class="pt-24 pb-20">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="letter-spacing: -0.02em;">
        {{ $page->page_title ?? $page->title }}
      </h1>
      @if($page->page_subtitle)
      <p class="text-xl text-gray-600 max-w-2xl mx-auto">
        {{ $page->page_subtitle }}
      </p>
      @endif
    </div>
    @if($page->content)
    <div class="prose max-w-none text-gray-600">
      {!! $page->content !!}
    </div>
    @endif
  </div>
</main>
@endsection
