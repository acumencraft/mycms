@extends('layouts.main')

@section('title', optional($page)->seo_title ?? 'Portfolio - ' . config('agency.name'))
@section('description', optional($page)->seo_description ?? 'Explore our portfolio of successful web development projects and digital solutions.')

@section('content')
<div class="min-h-screen bg-white pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="letter-spacing: -0.02em;">
                {{ optional($page)->hero_title ?? 'Our portfolio' }}
            </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    {{ optional($page)->hero_subtitle ?? 'Showcasing our latest projects and digital solutions' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $index => $project)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
                        <div class="aspect-video bg-gradient-to-br from-primary/20 to-primary/5 overflow-hidden">
                            @if($project->cover_image)
                                <img
                                    src="{{ asset('storage/' . $project->cover_image) }}"
                                    alt="{{ $project->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/5"></div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $project->title }}</h3>
                            <p class="text-gray-600 mb-4 leading-relaxed">{{ Str::limit($project->description, 120) }}</p>
                            @if($project->technologies)
                                @php
                                    $techs = is_array($project->technologies) ? $project->technologies : explode(',', $project->technologies);
                                @endphp
                                <div class="flex flex-wrap gap-2">
                                    @foreach($techs as $tech)
                                        @if(trim($tech))
                                            <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">{{ trim($tech) }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            @if($project->project_url)
                                <div class="mt-4">
                                    <a href="{{ $project->project_url }}" target="_blank" class="inline-flex items-center text-sm font-medium text-primary hover:text-primary/80 transition-colors">
                                        View Project
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($projects->isEmpty())
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg">No projects found.</p>
                </div>
            @endif
        </div>
    </div>
@endsection