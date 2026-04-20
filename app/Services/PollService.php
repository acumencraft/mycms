<?php

namespace App\Services;

use App\Repositories\PollRepository;
use App\Models\Poll;
use Illuminate\Support\Facades\Auth;

class PollService
{
    protected $pollRepository;

    public function __construct(PollRepository $pollRepository)
    {
        $this->pollRepository = $pollRepository;
    }

    public function getAvailablePolls()
    {
        return $this->pollRepository->getActivePolls();
    }

    public function getPollById(int $id): ?Poll
    {
        return $this->pollRepository->findPollById($id);
    }

    public function submitVote(int $pollId, int $optionId): array
    {
        $userId = Auth::id();
        $ipAddress = request()->ip();

        if (!$userId && !$ipAddress) {
            throw new \Exception('Cannot record vote without user ID or IP address.');
        }

        try {
            $this->pollRepository->recordVote($pollId, $optionId, $userId ?? 0, $ipAddress);
            return ['success' => true, 'message' => 'Vote recorded successfully.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function hasVoted(int $pollId): bool
    {
        $userId = Auth::id();
        $ipAddress = request()->ip();
        return $this->pollRepository->hasUserVoted($pollId, $userId ?? 0, $ipAddress);
    }

    public function getPollResults(int $pollId): ?Poll
    {
        $poll = $this->pollRepository->findPollById($pollId);

        if (!$poll) {
            return null;
        }

        $totalVotes = $poll->options->sum('votes_count');

        foreach ($poll->options as $option) {
            $option->percentage = $totalVotes > 0 ? round(($option->votes_count / $totalVotes) * 100, 2) : 0;
        }

        return $poll;
    }
}
