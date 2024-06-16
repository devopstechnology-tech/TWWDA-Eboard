<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMembershipRequest;
use App\Models\Module\Member\Membership;
use App\Repository\Contracts\MembershipInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MembershipController extends Controller
{
    //

    public function __construct(private readonly MembershipInterface $membershipRepository)
    {
    }
    public function getmeetingboardmemberships($meeting, $board): JsonResponse
    {
        $memberships = $this->membershipRepository->getMeetingBoardMemberships($meeting, $board);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $memberships, Membership::class);
    }
    public function updatemeetingboardmemberships(UpdateMembershipRequest $request, $meeting, $schedule): JsonResponse
    {
        $memberships = $this->membershipRepository->updateMeetingBoardMemberships($meeting, $schedule, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $memberships, Membership::class);
    }
}