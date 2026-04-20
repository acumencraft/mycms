<?php

namespace App\Repositories;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use Illuminate\Support\Collection;

class PollRepository
{
    public function getActivePolls(): Collection
    {
        return Poll::where('status', 'active')->with('options')->get();
    }

    public function findPollById(int $id): ?Poll
    {
        return Poll::with('options')->find($id);
    }

    public function recordVote(int $pollId, int $optionId, int $userId, string $ipAddress): PollVote
    {
        // Ensure the vote is unique per user/IP for a given poll
        // In a real scenario, you might want to use a unique constraint on (poll_id, user_id) or (poll_id, ip_address)
        // For now, we'll prevent duplicate votes for the same poll by the same user or IP
        $existingVote = PollVote::where('poll_id', $pollId)
            ->where(function ($query) use ($userId, $ipAddress) {
                $query->where('user_id', $userId)
                      ->orWhere('ip_address', $ipAddress);
            })
            ->first();

        if ($existingVote) {
            throw new \Exception('User or IP has already voted in this poll.');
        }

        $vote = PollVote::create([
            'poll_id' => $pollId,
            'poll_option_id' => $optionId,
            'user_id' => $userId,
            'ip_address' => $ipAddress,
        ]);

        // Increment votes_count for the option
        PollOption::where('id', $optionId)->increment('votes_count');

        return $vote;
    }

    public function hasUserVoted(int $pollId, int $userId, string $ipAddress): bool
    {
        return PollVote::where('poll_id', $pollId)
            ->where(function ($query) use ($userId, $ipAddress) {
                $query->where('user_id', $userId)
                    ->orWhere('ip_address', $ipAddress);
            })
            ->exists();
    }
}
