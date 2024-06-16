<?php

declare(strict_types=1);

namespace App\Repository;

use App\Enums\PublishEnum;
use App\Enums\ApprovalEnum;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Module\Meeting\Minute;
use App\Http\Resources\MinuteResource;
use App\Repository\Contracts\MinuteInterface;
use App\Repository\Contracts\MembershipInterface;
use App\Repository\Contracts\DetailMinuteInterface;

class MinuteRepository extends BaseRepository implements MinuteInterface
{
    // Implement the methods
    public function __construct(
        private readonly DetailMinuteInterface $detailminuteRepository,
        private readonly MembershipInterface $membershipRepository
    ) {
    }
    public function relationships()
    {
        return [
            'detailminutes.subdetailminutes',
            'schedule.meeting',
            'board',
            'committee',
            'author'
        ];
    }
    public function getAll()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical MinuteResource for transformation
        $filters = [
            'owner_id' => Auth::user()->id,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Minute::class, MinuteResource::class, $filters);
    }

    public function get(Minute|string $minute): Minute
    {
        if (!($minute instanceof Minute)) {
            $minute = Minute::findOrFail($minute);
        }

        return $minute;
    }

    public function getScheduleMinutes($schedule)
    {
        $minute = Minute::with($this->relationships())->where('schedule_id', $schedule)->first();
        return MinuteResource::make($minute);
    }

    // Implement the methods

    public function create($schedule, array $payload): Minute
    {
        $minute = isset($payload['minute_id']) && !empty($payload['minute_id'])
            ? Minute::findOrFail($payload['minute_id'])
            : new Minute();

        $minute->schedule_id = $schedule;
        $minute->membership_id = $this->membershipRepository->getAuthMembership()->id;
        $minute->status = PublishEnum::Default->value;
        $minute->approvalstatus = ApprovalEnum::Default->value;
        $minute->save();

        $this->detailminuteRepository->create($minute, $payload);

        return $minute;
    }

    public function update($minute, array $payload): Minute
    {
        $minute = Minute::findOrFail($payload['minute_id']);
        if ($minute) {
            $this->detailminuteRepository->update($minute, $payload);
        }
        return $minute;
    }
    public function createSubMinute($schedule, array $payload): Minute
    {
        $minute = Minute::findOrFail($payload['minute_id']);
        $this->detailminuteRepository->createSubMinute($minute, $payload);

        return $minute;
    }
    public function updateSubMinute($subminute, array $payload): Minute
    {
        $minute = Minute::findOrFail($payload['minute_id']);
        $this->detailminuteRepository->updateSubMinute($minute, $payload);

        return $minute;
    }
    public function ceoApprovalMinute(Minute|string $minute): bool
    {
        if (!($minute instanceof Minute)) {
            $minute = Minute::findOrFail($minute);
        }
        $minute->approvalstatus = ApprovalEnum::Approved->value;

        return $minute->save();
    }
    public function AcceptceoApprovalMinute(Minute|string $minute): bool
    {
        if (!($minute instanceof Minute)) {
            $minute = Minute::findOrFail($minute);
        }
        $minute->approvalstatus = ApprovalEnum::Approved->value;

        return $minute->save();
    }
    public function publishMinute(Minute|string $minute): bool
    {
        if (!($minute instanceof Minute)) {
            $minute = Minute::findOrFail($minute);
        }
        $minute->status = PublishEnum::Published->value;

        return $minute->save();
    }
    public function signaturesMinute(Minute|string $minute): bool
    {
        if (!($minute instanceof Minute)) {
            $minute = Minute::findOrFail($minute);
        }
        return $minute->delete();
    }
    public function deleteMinute(Minute|string $minute): bool
    {
        if (!($minute instanceof Minute)) {
            $minute = Minute::findOrFail($minute);
        }

        return $minute->delete();
    }
}
