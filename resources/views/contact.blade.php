@extends('layouts.main')

@section('title', optional($page)->seo_title ?? 'Contact - ' . config('agency.seo.title_suffix'))
@section('description', optional($page)->seo_description ?? 'Contact ' . config('agency.full_name'))

@section('content')
<div class="min-h-screen bg-white pt-24 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style="letter-spacing: -0.02em;">
                {{ optional($page)->hero_title ?? 'Contact Us' }}
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                {{ optional($page)->hero_subtitle ?? 'Ready to start your next project? Get in touch with us today.' }}
            </p>
        </div>

        <!-- Contact Form Section -->
        <div class="max-w-lg mx-auto">
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea name="message" id="message" rows="4" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection