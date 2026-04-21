@extends('layouts.main')

@section('title', optional($page)->seo_title ?? 'About - ' . config('agency.seo.title_suffix'))
@section('description', optional($page)->seo_description ?? 'About ' . config('agency.full_name'))

@section('content')
<div class="min-h-screen bg-white pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="letter-spacing: -0.02em;">
                {{ optional($page)->hero_title ?? 'About Us' }}
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                {{ optional($page)->hero_subtitle ?? 'Learn more about our mission, values, and the team behind ' . config('agency.name') . '.' }}
            </p>
        </div>

        <div class="prose prose-lg max-w-4xl mx-auto">
            @if($page && $page->content)
                {!! $page->content !!}
            @else
                <p>{{ config('agency.name') }} is a leading web development agency dedicated to creating exceptional digital experiences. We combine cutting-edge technology with creative design to help businesses thrive online.</p>
                <p>Our team of experienced developers, designers, and strategists work together to deliver high-quality solutions that drive results for our clients.</p>
            @endif
        </div>
    </div>
</div>
@endsection