@extends('layouts.main')
@section('title', $publication->title . ' - ' . config('agency.name') . ' Blog')
@section('description', $publication->excerpt ?? Str::limit(strip_tags($publication->content), 160))

@section('content')
<main class="pt-24 pb-20">
  <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <header class="mb-10 text-center">
      @if($publication->categories->count() > 0)
        <div class="flex justify-center gap-2 mb-4">
          @foreach($publication->categories as $category)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-primary">
              {{ $category->name }}
            </span>
          @endforeach
        </div>
      @endif

      <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight" style="letter-spacing: -0.02em;">
        {{ $publication->title }}
      </h1>

      @if($publication->excerpt)
        <p class="text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto mb-4">
          {{ $publication->excerpt }}
        </p>
      @endif

      <div class="flex items-center justify-center gap-3 text-sm text-gray-400">
        @if($publication->author)
          <span>By {{ $publication->author->name }}</span>
          <span>•</span>
        @endif
        @if($publication->published_at)
          <time>{{ $publication->published_at->format('M j, Y') }}</time>
        @endif
      </div>
    </header>

    {{-- Cover Image --}}
    @if($publication->cover_image)
    <div class="mb-10 rounded-xl overflow-hidden shadow-lg">
      <img src="{{ asset('storage/'.$publication->cover_image) }}" alt="{{ $publication->title }}"
           class="w-full h-72 object-cover">
    </div>
    @endif

    {{-- Content --}}
    <div class="prose prose-lg prose-gray max-w-none mb-12">
      {!! $publication->content !!}
    </div>

    {{-- Tags --}}
    @if($publication->tags->count() > 0)
    <div class="border-t border-gray-200 pt-8 mb-12">
      <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-4">Tags</h3>
      <div class="flex flex-wrap gap-2">
        @foreach($publication->tags as $tag)
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors">
            {{ $tag->name }}
          </span>
        @endforeach
      </div>
    </div>
    @endif
    
    {{-- Comments --}}
    {{-- Custom Comments Section --}}
<div class="mt-16 border-t border-gray-100 pt-10 mb-12">
    <h3 class="text-2xl font-bold text-gray-900 mb-8">Comments ({{ $publication->comments->count() }})</h3>

    {{-- Comment Form --}}
@auth
    {{-- ფორმა მხოლოდ ავტორიზებულებისთვის --}}
    <form action="{{ route('comments.store', $publication) }}" method="POST" class="mb-12 bg-gray-50 p-6 rounded-xl">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Leave a comment as {{ auth()->user()->name }}</label>
            <textarea name="content" rows="3" required placeholder="Write your thoughts..."
                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring-primary"></textarea>
        </div>
        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary/90 transition">
            Post Comment
        </button>
    </form>
@else
    {{-- შეტყობინება სტუმრებისთვის --}}
    <div class="mb-12 bg-blue-50 p-6 rounded-xl text-center">
        <p class="text-gray-700">To leave a comment, please follow the link:
 <a href="{{ route('login') }}" class="text-primary font-bold underline">login</a>.</p>
    </div>
@endauth

    {{-- Comments List --}}
    <div class="space-y-8">
        @foreach($publication->comments as $comment)
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-500">
                        {{ substr($comment->user ? $comment->user->name : $comment->user_name, 0, 1) }}
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-bold text-gray-900">{{ $comment->user ? $comment->user->name : $comment->user_name }}</span>
                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-600 leading-relaxed">{{ $comment->content }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

    {{-- Back --}}
    <div class="text-center">
      <a href="{{ route('blog') }}"
         class="inline-flex items-center px-6 py-3 text-base font-medium rounded-md text-white bg-primary hover:bg-primary/90 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Blog
      </a>
    </div>

  </article>
</main>
@endsection
