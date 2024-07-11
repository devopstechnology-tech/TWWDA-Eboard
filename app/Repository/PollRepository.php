<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Http\Request;
use App\Models\Module\Poll\Poll;
use App\Models\Module\Board\Board;
use App\Http\Resources\PollResource;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Committe\Committee;
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
            // 'memberships.user',
            'pollassignees',
            // 'pollassignees.poll',
        ];
    }

    // Implement the methods
    public function getAll()
    {
        $filters = [
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc'],
            'includeDeleted' => 'with' // Options are 'with', 'only', or not set (to exclude)
        ]; 
        return $this->indexResource(Poll::class, PollResource::class, $filters);
    }
    public function getLatest()
    {
        $filters = [
            'limit' => 4,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc'],
            'includeDeleted' => 'with' // Options are 'with', 'only', or not set (to exclude)
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
    //meeting
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
    public function createMeetingPoll(Meeting|string $meeting, array $payload): Poll
    {
        // dd($payload['pollassignees']);
        $poll = new Poll();
        $poll->meeting_id = $payload['meeting_id'];
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
            $payload['entity_type'] = get_class($meeting); // Pass the entity type
            $this->getOptionRepository()->create($poll, $payload);
            $this->getAssigneePollRepository()->create($poll, $payload);
        }
        return $poll;
    }
    public function updateMeetingPoll(Meeting|string $meeting, Poll $poll, array $payload): Poll
    {
        if (!($poll instanceof Poll)) {
            $poll = Poll::findOrFail($poll);
        }
        $poll->meeting_id = $payload['meeting_id'];
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
            $payload['entity_type'] = get_class($meeting); // Pass the entity type
            $this->getAssigneePollRepository()->update($poll, $payload);
            $this->getOptionRepository()->update($poll, $payload);
        }

        return $poll;
    }

    //board
    public function getBoardPolls($board)
    {
        $filters = [
            'board_id' => $board,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Poll::class, PollResource::class, $filters);
    }
    public function createBoardPoll(Board $board, array $payload): Poll
    {
        // dd($payload['pollassignees']);
        $poll = new Poll();
        $poll->board_id       = $payload['board_id'];
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
            $payload['entity_type'] = get_class($board); // Pass the entity type
            $this->getAssigneePollRepository()->update($poll, $payload);
            $this->getOptionRepository()->update($poll, $payload);
        }
        return $poll;
    }
    public function updateBoardPoll(Poll $poll, array $payload): Poll
    {
        if (!($poll instanceof Poll)) {
            $poll = Poll::findOrFail($poll);
        }
        $poll->board_id       = $payload['board_id'];
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
            $payload['entity_type'] = get_class($poll->board); // Pass the entity type
            $this->getAssigneePollRepository()->update($poll, $payload);
            $this->getOptionRepository()->update($poll, $payload);
        }
        return $poll;
    }
    //committee
    public function getCommitteePolls($committee)
    {
        $filters = [
            'committee_id' => $committee,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Poll::class, PollResource::class, $filters);
    }
    public function createCommitteePoll(Committee $committee, array $payload): Poll
    {
        // dd($payload['pollassignees']);
        $poll = new Poll();
        $poll->committee_id   = $payload['committee_id'];
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
            $payload['entity_type'] = get_class($committee); // Pass the entity type
            $this->getAssigneePollRepository()->update($poll, $payload);
            $this->getOptionRepository()->update($poll, $payload);
        }
        return $poll;
    }
    public function updateCommitteePoll(Poll $poll, array $payload): Poll
    {
        if (!($poll instanceof Poll)) {
            $poll = Poll::findOrFail($poll);
        }
        $poll->committee_id   = $payload['committee_id'];
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
            $payload['entity_type'] = get_class($poll->committee); // Pass the entity type
            $this->getAssigneePollRepository()->update($poll, $payload);
            $this->getOptionRepository()->update($poll, $payload);
        }
        return $poll;
    }
}