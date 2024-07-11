<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Member;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Module\Board\Board;
use App\Http\Controllers\Controller;
use App\Models\Module\Member\Member;
use App\Models\Module\Committe\Committee;
use App\Http\Requests\UpdateMemberRequest;
use App\Repository\Contracts\MemberInterface;
use App\Http\Requests\UpdateMemberRoleRequest;
use App\Http\Requests\UpdateMemberPositionRequest;

class MemberController extends Controller
{
    public function __construct(private readonly MemberInterface $memberRepository)
    {
    }
    public function getboardmembers($member): JsonResponse
    {
        $members = $this->memberRepository->getBoardMembers($member);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $members, Member::class);
    }
    public function updateboardmembers(UpdateMemberRequest $request, Board $board): JsonResponse
    {
        $member = $this->memberRepository->updateBoardMembers($board, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $member);
    }
    public function updateboardmemberposition(UpdateMemberPositionRequest $request, Board $board): JsonResponse
    {
        $member = $this->memberRepository->updateBoardMemberPosition($board, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $member);
    }
    //committtee
    public function getcommitteemembers($member): JsonResponse
    {
        $members = $this->memberRepository->getCommitteeMembers($member);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $members, Member::class);
    }
    public function updatecommitteemembers(UpdateMemberRequest $request, Committee $committee): JsonResponse
    {
        $member = $this->memberRepository->updateCommitteeMembers($committee, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $member);
    }
    public function updatecommitteememberposition(UpdateMemberPositionRequest $request, Committee $committee): JsonResponse
    {
        $member = $this->memberRepository->updateCommitteeMemberPosition($committee, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $member);
    }


}