<?php

namespace App\Http\Controllers;

use App\Services\PollService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{
    protected $pollService;

    public function __construct(PollService $pollService)
    {
        $this->pollService = $pollService;
    }

    public function index()
    {
        $polls = $this->pollService->getAvailablePolls();
        return view('frontend.polls.index', compact('polls'));
    }

    public function show(int $id)
    {
        $poll = $this->pollService->getPollById($id);
        if (!$poll) {
            abort(404);
        }

        $hasVoted = $this->pollService->hasVoted($id);
        $results = $hasVoted ? $this->pollService->getPollResults($id) : null;

        return view('frontend.polls.show', compact('poll', 'hasVoted', 'results'));
    }

    public function vote(Request $request, int $id)
    {
        $request->validate([
            'option_id' => 'required|exists:poll_options,id',
        ]);

        if (!Auth::check() && !session()->has('guest_voted_poll_' . $id)) {
            // Allow guests to vote once per session, or handle via IP address in service
            // For simplicity, we'll use session for guests. Realistically, IP-based limiting is better.
            session()->put('guest_voted_poll_' . $id, true);
        } elseif (Auth::check() && $this->pollService->hasVoted($id)) {
            return back()->with('error', 'You have already voted in this poll.');
        }

        $result = $this->pollService->submitVote($id, $request->input('option_id'));

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }
}
