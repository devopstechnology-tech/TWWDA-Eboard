<?php

// App\Repository\DiscussionAssigneeRepository.php

namespace App\Repository;

use App\Models\User;
use App\Models\Module\Board\Board;
use App\Repository\BaseRepository;
use App\Models\Module\Member\Member;
use Illuminate\Support\Facades\Auth;
use App\Models\Module\Committe\Committee;
use App\Models\Module\Discussions\Discussion;
use App\Repository\Contracts\MemberInterface;
use App\Models\Module\Discussions\Sub\DiscussionAssignee;
use App\Repository\Contracts\DiscussionAssigneeInterface;

class DiscussionAssigneeRepository extends BaseRepository implements DiscussionAssigneeInterface
{
    private $memberRepository;

    public function __construct(MemberInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }
    public function getAuthAssignee($user, array $payload)
    {        
        $assignee = DiscussionAssignee::where('user_id', $user)
                                       ->where('discussion_id', $payload['discussion_id'])
                                       ->first();
        return $assignee;
    }
    public function create(User $user, Discussion $discussion, array $payload)
    {
        [$boards, $committees, $users] = $this->getCollection($payload);

        $this->assignBoards($discussion, $boards);
        $this->assignCommittees($discussion, $committees);
        $this->assignUsers($discussion, $users);
        $this->assingSelfIfNotExist($discussion, $user);
    }
    public function update(Discussion $discussion, array $payload)
    {
        [$boards, $committees, $users] = $this->getCollection($payload);

        // Get the current assignees
        $currentAssignees = DiscussionAssignee::where('discussion_id', $discussion->id)->get();

        // Prepare the new assignees
        $newAssignees = collect();

        $newAssignees = $newAssignees->merge($this->prepareAssignees($boards, 'board', $discussion));
        $newAssignees = $newAssignees->merge($this->prepareAssignees($committees, 'committee', $discussion));
        $newAssignees = $newAssignees->merge($this->prepareAssignees($users, 'user', $discussion));
        // $newAssignees->push(['user_id' => $user->id, 'assignable_type' => User::class, 'assignable_id' => $user->id]);
        $this->assingSelfIfNotExist($discussion, $discussion->user_id);

        // Remove old assignees that are not in the new assignees list
        foreach ($currentAssignees as $currentAssignee) {
            if (!$newAssignees->contains(function ($assignee) use ($currentAssignee) {
                return $assignee['user_id'] === $currentAssignee->user_id &&
                       $assignee['assignable_type'] === $currentAssignee->assignable_type &&
                       $assignee['assignable_id'] === $currentAssignee->assignable_id;
            })) {
                $currentAssignee->delete();
            }
        }

        // Add new assignees
        foreach ($newAssignees as $newAssignee) {
            if (!$currentAssignees->contains(function ($assignee) use ($newAssignee) {
                return $assignee->user_id === $newAssignee['user_id'] &&
                       $assignee->assignable_type === $newAssignee['assignable_type'] &&
                       $assignee->assignable_id === $newAssignee['assignable_id'];
            })) {
                $this->createDiscussionAssignee($discussion, $newAssignee['user_id'], $newAssignee['assignable_type'], $newAssignee['assignable_id']);
            }
        }
    }
    public function delete(Discussion $discussion)
    {
        $assingees = DiscussionAssignee::where('discussion_id', $discussion->id)->delete();
        return true;
    }
    public function leave(Discussion $discussion)
    {
        $assingees = DiscussionAssignee::where('discussion_id', $discussion->id)
                                       ->where('user_id', Auth::user()->id)
                                       ->delete();
        return true;
    }

    private function prepareAssignees($entities, $class, Discussion $discussion)
    {
        $assignees = collect();

        if ($class === 'board') {
            foreach ($entities as $board) {
                $members = $this->memberRepository->getBoardCollectionMembers($board['id']);
                foreach ($members as $member) {
                    $assignees->push(['user_id' => $member->user_id, 'assignable_type' => Member::class, 'assignable_id' => $member->id]);
                }
            }
        } elseif ($class === 'committee') {
            foreach ($entities as $committee) {
                $members = $this->memberRepository->getCommitteeCollectionMembers($committee['id']);
                foreach ($members as $member) {
                    $assignees->push(['user_id' => $member->user_id, 'assignable_type' => Member::class, 'assignable_id' => $member->id]);
                }
            }
        } elseif ($class === 'user') {
            foreach ($entities as $user) {
                $assignees->push(['user_id' => $user['id'], 'assignable_type' => User::class, 'assignable_id' => $user['id']]);
            }
        }

        return $assignees;
    }

    private function assingSelfIfNotExist(Discussion $discussion, $user)
    {
        if (!($user instanceof User)) {
            $user = User::findOrFail($user);
        }
        $selfassignee = DiscussionAssignee::where('user_id', $user->id)->first();
        if(!$selfassignee){
            $this->createDiscussionAssignee($discussion, $user->id, User::class, $user->id);
        }           
    }
    private function assignBoards(Discussion $discussion, $boards)
    {
        foreach ($boards as $board) {
            $members = $this->memberRepository->getBoardCollectionMembers($board['id']);
            foreach ($members as $member) {
                $this->createDiscussionAssignee($discussion, $member->user_id, Member::class, $member->id);
            }
        }
    }

    private function assignCommittees(Discussion $discussion, $committees)
    {
        foreach ($committees as $committee) {
            $members = $this->memberRepository->getCommitteeCollectionMembers($committee['id']);
            foreach ($members as $member) {
                $this->createDiscussionAssignee($discussion, $member->user_id, Member::class, $member->id);
            }
        }
    }

    private function assignUsers(Discussion $discussion, $users)
    {
        foreach ($users as $user) {
            $this->createDiscussionAssignee($discussion, $user['id'], User::class, $user['id']);
        }
    }

    private function createDiscussionAssignee(Discussion $discussion, $userId, $assignableType, $assignableId)
    {
        DiscussionAssignee::create([
            'discussion_id'   => $discussion->id,
            'user_id'         => $userId,
            'assignable_id'   => $assignableId,
            'assignable_type' => $assignableType,
        ]);
    }

    private function getCollection(array $payload): array
    {
        $boards = collect($payload['discussionassignees'])->filter(function ($assignee) {
            return $assignee['class'] === 'board';
        })->values()->toArray();

        $committees = collect($payload['discussionassignees'])->filter(function ($assignee) {
            return $assignee['class'] === 'committee';
        })->values()->toArray();

        $users = collect($payload['discussionassignees'])->filter(function ($assignee) {
            return $assignee['class'] === 'user';
        })->values()->toArray();

        return [$boards, $committees, $users];
    }
}
