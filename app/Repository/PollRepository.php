<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Http\Request;
use App\Models\Module\Poll\Poll;
use App\Models\Module\Board\Board;
use App\Http\Resources\PollResource;
use App\Models\Module\Meeting\Meeting;
use App\Repository\Contracts\PollInterface;
use App\Repository\Contracts\OptionInterface;
use App\Repository\Contracts\AssigneePollInterface;

class PollRepository extends BaseRepository implements PollInterface
{
    private $optionRepository;
    private $assigneepollRepository;

    public function getAssigneePollRepository(): AssigneePollInterface
    {
        // Lazily load the AssigneePollRepository when needed
        return $this->assigneepollRepository ??= resolve(AssigneePollInterface::class);
    }

    public function getOptionRepository(): OptionInterface
    {
        // Lazily load the OptionRepository when needed
        return $this->optionRepository ??= resolve(OptionInterface::class);
    }
    public function relationships()
    {
        return [
            'meeting',
            'board',
            'committee',
            'options',
            'votes',
            'memberships.user',
            'pollassignees.user',
            // 'pollassignees.poll',
        ];
    }

    // Implement the methods
    public function getAll()
    {
        $filters = [
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Poll::class, PollResource::class, $filters);
    }
    public function getMeetingPolls($meeting)
    {
        $filters = [
            'with' => $this->relationships(),
            'meeting_id' => $meeting,
            'orderBy' => ['field' => 'id', 'direction' => 'asc'],
            'includeDeleted' => '' // Options are 'with', 'only', or not set (to exclude)
        ];        
        return $this->indexResource(Poll::class, PollResource::class, $filters);
    }
    public function getPoll(Poll |string $poll)
    {
        if (!($poll instanceof Poll)) {
            $poll = Poll::with($this->relationships())->findOrFail($poll);
        }
        return $poll->load($this->relationships());
    }
    public function createMeetingPoll(Meeting|string $meeting, Board|string $board, array $payload): Poll
    {

        $poll = new Poll();

        $poll->meeting_id = $payload['meeting_id'];
        $poll->board_id = $payload['board_id'];
        $poll->committee_id = $payload['committee_id'];
        $poll->question = $payload['question'];
        $poll->description = $payload['description'];
        $poll->questionoptiontype = $payload['questionoptiontype'];
        $poll->optionstatus = $payload['optionstatus'];
        $poll->duedate = $payload['duedate'];
        $poll->assigneetype = $payload['assigneetype'];
        $poll->assigneestatus = $payload['assigneestatus'];
        $poll->status = $payload['status'];
        $poll->save();

        if ($poll->wasRecentlyCreated) {
            $this->getOptionRepository()->create($poll, $payload);
            $this->getAssigneePollRepository()->create($poll, $payload);
        }
        return $poll;
    }
    public function updateMeetingPoll(Meeting|string $meeting, $board, Poll $poll, array $payload): Poll
    {
        if (!($poll instanceof Poll)) {
            $poll = Poll::findOrFail($poll);
        }
        $poll->meeting_id = $payload['meeting_id'];
        $poll->board_id = $payload['board_id'];
        $poll->committee_id = $payload['committee_id'];
        $poll->question = $payload['question'];
        $poll->description = $payload['description'];
        $poll->questionoptiontype = $payload['questionoptiontype'];
        $poll->optionstatus = $payload['optionstatus'];
        $poll->duedate = $payload['duedate'];
        $poll->assigneetype = $payload['assigneetype'];
        $poll->assigneestatus = $payload['assigneestatus'];
        $poll->status = $payload['status'];
        $poll->save();

        if ($poll->save()) {
            $this->getAssigneePollRepository()->update($poll, $payload);
            $this->getOptionRepository()->update($poll, $payload);
        }
        return $poll;
    }
}