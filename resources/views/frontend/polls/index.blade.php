<?php

/** @var \Illuminate\Support\Collection $polls */
?>

@extends('layouts.app') {{-- Assuming a base layout exists --}}

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Polls</h1>

    @if($polls->isEmpty())
        <p>No active polls available at the moment.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($polls as $poll)
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                    <h2 class="text-xl font-semibold mb-3">
                        <a href="{{ route('polls.show', $poll->id) }}" class="text-blue-600 hover:underline">
                            {{ $poll->question }}
                        </a>
                    </h2>
                    <p class="text-gray-600 mb-4">Status: <span class="font-medium {{ $poll->status === 'active' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($poll->status) }}</span></p>
                    <div class="flex justify-end">
                        <a href="{{ route('polls.show', $poll->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                            View Poll
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
