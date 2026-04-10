@extends('layouts.main')

@section('title', $title ?? 'Login - ' . config('agency.seo.title_suffix') . '')
@section('description', $description ?? 'Login to your ' . config('agency.name') . ' account')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <a href="{{ route('home') }}" class="text-3xl font-bold text-primary">
                {{ data_get($siteSettings, 'site_name', 'archvadze') }}
            </a>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ $title ?? 'Sign in to your account' }}
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                <a href="{{ route('home') }}" class="font-medium text-primary hover:text-primary/80 transition-colors">
                    return to homepage
                </a>
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            @yield('auth-content')
        </div>
    </div>
</div>
@endsection