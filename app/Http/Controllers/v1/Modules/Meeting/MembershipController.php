<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Meeting;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Module\Member\Membership;
use App\Http\Requests\UpdateMembershipRequest;
use App\Repository\Contracts\MembershipInterface;
use App\Http\Requests\UpdateMembershipPositionRequest;

class MembershipController extends Controller
{
    //

    public function __construct(private readonly MembershipInterface $membershipRepository)
    {
    }
    public function getmeetingmemberships($meeting, $board): JsonResponse
    {
        $memberships = $this->membershipRepository->getMeetingMemberships($meeting, $board);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $memberships, Membership::class);
    }
    public function updatememberships(UpdateMembershipRequest $request, $meeting, $schedule): JsonResponse
    {
        $memberships = $this->membershipRepository->updateMemberships($meeting, $schedule, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $memberships, Membership::class);
    }
    public function updateposition(UpdateMembershipPositionRequest $request, $meeting, $schedule): JsonResponse
    {
        $memberships = $this->membershipRepository->updateMembershipPosition($meeting, $schedule, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $memberships, Membership::class);
    }
}