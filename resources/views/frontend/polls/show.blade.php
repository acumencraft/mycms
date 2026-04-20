<?php

/** @var \App\Models\Poll $poll */
/** @var bool $hasVoted */
/** @var \App\Models\Poll|null $results */
?>

@extends('layouts.app') {{-- Assuming a base layout exists --}}

@section('content')
<div class="container mx-auto p-4">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8 mb-8">
        <h1 class="text-3xl font-bold mb-4">{{ $poll->question }}</h1>

        @if ($hasVoted && $results)
            <div class="mb-6">
                <h2 class="text-2xl font-semibold mb-4">Results:</h2>
                @foreach ($results->options as $option)
                    <div class="mb-3 p-4 rounded-md {{ $option->percentage > 0 ? 'bg-blue-50' : 'bg-gray-50' }} border {{ $option->percentage > 0 ? 'border-blue-200' : 'border-gray-200' }}">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-lg">{{ $option->option_text }}</span>
                            <span class="text-sm text-gray-700">{{ $option->percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $option->percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
                <p class="text-sm text-gray-600 mt-4">Total Votes: {{ $results->options->sum('votes_count') }}</p>
            </div>
        @elseif ($poll->status === 'inactive')
            <p class="text-lg text-red-600 font-semibold mb-6">This poll is currently inactive.</p>
        @elseif ($hasVoted)
             <p class="text-lg text-gray-700 font-semibold mb-6">You have already voted in this poll.</p>
        @else
            <form action="{{ route('polls.vote', $poll->id) }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-lg font-semibold mb-2">Choose your option:</label>
                    @foreach ($poll->options as $option)
                        <div class="flex items-center mb-3">
                            <input type="radio" id="option_{{ $option->id }}" name="option_id" value="{{ $option->id }}" class="form-radio h-5 w-5 text-blue-600 transition duration-150 ease-in-out" required>
                            <label for="option_{{ $option->id }}" class="ml-3 block text-base text-gray-700 cursor-pointer">
                                {{ $option->option_text }}
                            </label>
                        </div>
                    @endforeach
                    @error('option_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="px-6 py-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                    Vote
                </button>
            </form>
        @endif

        <a href="{{ route('polls.index') }}" class="text-blue-600 hover:underline inline-block">
            &larr; Back to all polls
        </a>
    </div>
</div>
@endsection
