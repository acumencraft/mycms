@extends('layouts.main')
@section('title', 'Testimonials - ' . config('agency.seo.title_suffix'))

@section('content')
<main class="pt-24 pb-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-16">
      <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="letter-spacing:-0.02em">
        What Our Clients Say
      </h1>
      <p class="text-xl text-gray-600">Real feedback from businesses we've helped grow</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
      @foreach($testimonials as $testimonial)
      <div class="border border-gray-200 rounded-2xl p-8">
        <svg class="w-8 h-8 text-primary/30 mb-4" fill="currentColor" viewBox="0 0 24 24">
          <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.598-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.598-3.996 5.849h3.983v10h-9.983z"/>
        </svg>
        <p class="text-gray-700 leading-relaxed mb-6">{{ $testimonial->testimonial_text }}</p>
        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
          @if($testimonial->photo)
            <img src="{{ asset('storage/'.$testimonial->photo) }}"
                 alt="{{ $testimonial->client_name }}"
                 class="w-10 h-10 rounded-full object-cover">
          @else
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
              <span class="text-primary font-bold text-sm">{{ substr($testimonial->client_name, 0, 1) }}</span>
            </div>
          @endif
          <div>
            <p class="font-semibold text-gray-900 text-sm">{{ $testimonial->client_name }}</p>
            <p class="text-xs text-gray-500">{{ $testimonial->client_position }}{{ $testimonial->company ? ', '.$testimonial->company : '' }}</p>
          </div>
          <div class="ml-auto flex gap-0.5">
            @for($i = 1; $i <= 5; $i++)
              <svg class="w-4 h-4 {{ $i <= ($testimonial->rating ?? 5) ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
              </svg>
            @endfor
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="mt-16 text-center bg-primary/5 rounded-2xl p-10">
      <h3 class="text-2xl font-bold text-gray-900 mb-3">Ready to work with us?</h3>
      <p class="text-gray-600 mb-6">Join our satisfied clients and transform your digital presence.</p>
      <a href="{{ route('order.create') }}"
         class="inline-flex items-center rounded-md bg-primary text-primary-foreground hover:bg-primary/90 text-sm font-medium h-10 px-8">
        Start Your Project
      </a>
    </div>

  </div>
</main>
@endsection
