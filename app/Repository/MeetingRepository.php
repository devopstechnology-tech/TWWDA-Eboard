<?php

declare(strict_types=1);

namespace App\Repository;

use stdClass;
use App\Models\User;
use App\Enums\PublishEnum;
use App\Enums\ScheduletypeEnum;
use App\Models\Module\Board\Board;
use Illuminate\Support\Facades\Auth;
use App\Models\Module\Meeting\Meeting;
use App\Http\Resources\MeetingResource;
use App\Models\Module\Committe\Committee;
use App\Repository\Contracts\BoardInterface;
use App\Notifications\NewMeetingNotification;
use App\Repository\Contracts\FolderInterface;
use App\Repository\Contracts\MemberInterface;
use App\Repository\Contracts\MeetingInterface;
use App\Repository\Contracts\ScheduleInterface;
use App\Repository\Contracts\CommitteeInterface;
use App\Repository\Contracts\MembershipInterface;

class MeetingRepository extends BaseRepository implements MeetingInterface
{
    // Implement the methods
    public function __construct(
        private readonly ScheduleInterface $scheduleRepository,
        private readonly BoardInterface $boardRepository,
        private readonly MemberInterface $memberRepository,
        private readonly CommitteeInterface $committeeRepository,
        private readonly FolderInterface $folderRepository,
    ) {
    }
    public function relationships()
    {
        return [
            // 'attendances.membership',
            'owner',
            'schedules',
            'meetingable', // Add this to handle polymorphic relation
            // 'agendas',      // Assuming you want to load agendas associated with the meetings
            'folders',      // Assuming you want to load agendas associated with the meetings
        ];
    }
    public function getAll()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical MeetingResource for transformation
        $filters = [
            // 'owner_id' => Auth::user()->id,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Meeting::class, MeetingResource::class, $filters);
    }

    public function get(Meeting|string $meeting): Meeting
    {
        if (!($meeting instanceof Meeting)) {
            $meeting = Meeting::findOrFail($meeting);
        }

        return $meeting;
    }
    public function getboardMeeting($meeting)
    {
        $meeting = Meeting::with($this->relationships())->findOrFail($meeting);
        return $meeting;

        // return MeetingResource::make($meeting);
    }
    public function getcommitteeMeeting($meeting)
    {
        $meeting = Meeting::with($this->relationships())->findOrFail($meeting);
        return $meeting;
    }
    public function getBoardMeetings($meeting)
    {
        $filters = [
            'meetingable_id' => $meeting,
            'meetingable_type' => Board::class,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Meeting::class, MeetingResource::class, $filters);
    }
    public function getCommitteeMeetings($committee)
    {
        $filters = [
            'meetingable_id' => $committee,
            'meetingable_type' => Committee::class,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Meeting::class, MeetingResource::class, $filters);
    }
    public function publishMeeting($meeting)
    {
        if (!($meeting instanceof Meeting)) {
            $meeting = Meeting::findOrFail($meeting);
        }

        $meeting->status = PublishEnum::Published->value;
        $meeting->tempUserIds = $meeting->memberships()->pluck('user_id')->toArray();
        $meeting->isUpdate = false;
        $meeting->save();
    }
    // Implement the methods

    public function create($payload): Meeting
    {
        $meeting = new Meeting();
        $meeting->title       = $payload['title'];
        $meeting->conference  = $payload['conference'];
        $meeting->status      = PublishEnum::Default->value;
        $meeting->type        = ScheduletypeEnum::Default->value;
        if (!empty($payload['link'])) {
            $meeting->link        = $payload['link'];
        }
        $meeting->location    = $payload['location'];
        $meeting->description = $payload['description'];
        $meeting->owner_id    = Auth::user()->id;

        $class = '';
        $id = '';
        $member = '';
        $meetingCount = '';
        if (!empty($payload['committee_id'])) {
            $committee = Committee::find($payload['committee_id']);
            $class = Committee::class;
            $id    = $payload['committee_id'];
            $meetingCount = $committee->meetings()->count();

            $meeting->meetingable_type = Committee::class;
            $meeting->meetingable_id = $payload['committee_id'];
            $member = $this->memberRepository->fetchCommitteeMember($payload['committee_id']);
        } elseif (!empty($payload['board_id'])) {
            $board = Board::find($payload['board_id']);

            $class =  Board::class;
            $id    = $payload['board_id'];
            $meetingCount = $board->meetings()->count();

            $meeting->meetingable_type = Board::class;
            $meeting->meetingable_id = $payload['board_id'];
            $member = $this->memberRepository->fetchBoardMember($payload['board_id']);
        }
        $meeting->save();

        if ($meeting->save()) {
            $boardcommittee = new stdClass();
            $boardcommittee->class          = $class;
            $boardcommittee->id             = $id;
            $boardcommittee->meetingCount   = $meetingCount;

            $DefaultfolderNames = [
                "Meeting Attachments",
                "Meeting Minutes",
                "Meeting Attendance",
                "Meeting Archive",
            ];
            $this->folderRepository->createMeetingInitialFolder($meeting, $boardcommittee, $DefaultfolderNames);
            $this->scheduleRepository->createSchedule($meeting, $member, $payload);
        }
        return $meeting;
    }

    public function update(Meeting|string $meeting, array $payload): Meeting
    {

        if (!($meeting instanceof Meeting)) {
            $meeting = Meeting::findOrFail($meeting);
        }
        // dd($meeting,$payload);
        $meeting->title       = $payload['title'];
        $meeting->conference  = $payload['conference'];
        $meeting->location    = $payload['location'];
        $meeting->status      = $payload['status'];
        $meeting->type        = $payload['type'];

        if (!empty($payload['link'])) {
            $meeting->link        = $payload['link'];
        }
        $meeting->description = $payload['description'];
        $meeting->owner_id    = Auth::user()->id;
        // dd($meeting);
        if (!empty($payload['committee_id'])) {
            // $meeting->committee_id = $payload['committee_id'];
            $meeting->meetingable_type = Committee::class; // Set the meetingable_type to the Committee model
            $meeting->meetingable_id = $payload['committee_id'];
        } elseif (!empty($payload['board_id'])) {
            // $meeting->board_id = $payload['board_id'];
            $meeting->meetingable_type = Board::class; // Set the meetingable_type to the Board model
            $meeting->meetingable_id = $payload['board_id'];
        }
        $meeting->tempUserIds = $meeting->memberships()->pluck('user_id')->toArray();
        $meeting->isUpdate = true;
        $meeting->save();
        // dd($meeting);
        if ($meeting) {
            $this->scheduleRepository->updateSchedule($meeting, $payload);
            // $isUpdate = true;

            // Fetch all User instances in a single query using the retrieved IDs
            // $users = User::whereIn('id', $userIds)->get();

            // foreach ($users as $user) {
            //     $user->notify(new NewMeetingNotification($board, $meeting, $isUpdate));
            // }
        }
        return $meeting;
    }
    public function updateMembers(Meeting|string $meeting, array $payload): Meeting
    {
        if (!($meeting instanceof Meeting)) {
            $meeting = Meeting::findOrFail($meeting);
        }

        if ($meeting) {
            // $this->meetingMemberRepository->updateMembers($meeting, $payload);
        }

        return $meeting;
    }

    public function delete(Meeting|string $meeting): bool
    {
        if (!($meeting instanceof Meeting)) {
            $meeting = Meeting::findOrFail($meeting);
        }

        return $meeting->delete();
    } // Implement the methods

}
