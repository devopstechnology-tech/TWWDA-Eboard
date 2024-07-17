<?php

namespace App\Repository;

use Carbon\Carbon;
use App\Enums\VoteEnum;
use App\Models\Module\Poll\Poll;
use App\Repository\BaseRepository;
use App\Models\Module\Poll\Sub\Vote;
use App\Models\Module\Poll\Sub\Option;
use App\Repository\Contracts\VoteInterface;

class VoteRepository extends BaseRepository implements VoteInterface
{
    /**
     * Vote on a poll with the given payload.
     *
     * @param Poll $poll
     * @param array $payload
     * @return void
     */
    public function vote(Poll $poll, array $payload)
    {
        $vote = new Vote();
        $vote->option_id = $this->findOptionId($payload);
        $vote->poll_id = $payload['poll_id'];
        $vote->assignee_poll_id = $payload['poll_assignee_id'];
        $vote->date = Carbon::now();
        $vote->status = VoteEnum::Voted->value;
        $vote->save();
    }

    /**
     * Find the Option model by title for the given poll.
     *
     * @param array $payload
     * @return Option|null
     */
    private function findOptionId(array $payload): ?Option
    {
        return Option::where('poll_id', $payload['poll_id'])
                     ->where('title', $payload['selectedOption'])
                     ->first();
    }
}
