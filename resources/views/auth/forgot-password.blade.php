@extends('layouts.auth', ['title' => 'Reset your password'])

@section('auth-content')

<!-- Session Status -->
@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
        {{ session('status') }}
    </div>
@endif

<div class="mb-4 text-sm text-gray-600">
    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
</div>

<!-- Validation Errors -->
@if ($errors->any())
    <div class="mb-4">
        <ul class="text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-6">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">
            Email address
        </label>
        <div class="mt-1">
            <input id="email" name="email" type="email" autocomplete="email" required
                   value="{{ old('email') }}"
                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        </div>
    </div>

    <div>
        <button type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
            Email password reset link
        </button>
    </div>

    <div class="text-center">
        <p class="text-sm text-gray-600">
            Remember your password?
            <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary/80 transition-colors">
                Sign in
            </a>
        </p>
    </div>
</form>
@endsection
