<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Module\Board\Board;
use App\Models\Module\Member\Member;
use App\Repository\Contracts\MemberInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        $member = $this->memberRepository->updateMembers($board, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $member);
    }
}
