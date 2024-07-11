<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Module\Board\Board;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\Log;
use App\Models\Module\Member\Member;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MemberResource;
use App\Models\Module\Committe\Committee;
use App\Repository\Contracts\BoardInterface;
use App\Repository\Contracts\MemberInterface;
use App\Repository\Contracts\CommitteeInterface;

class MemberRepository extends BaseRepository implements MemberInterface
{
    public function __construct(
        private readonly BoardInterface $boardRepository,
        private readonly CommitteeInterface $committeeRepository,
        )
    {
    }
    public function relationships()
    {
        return [
            'board',
            'committee',
            'guest',
            'user',
            'position',
        ];
    }
    public function getAll()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical MemberResource for transformation
        $filters = [
            'with' => $this->relationships(),
            'user_id' => Auth::user()->id,
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Member::class, MemberResource::class, $filters);
    }
    public function fetchBoardMember($board)
    {
        $member =  Member::where('board_id', $board)
                     ->where('user_id', Auth::user()->id)->first();
                     return $member;
    }
    
    public function getBoardMembers($board)
    {
        $filters = [
            'board_id' => $board,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Member::class, MemberResource::class, $filters);
    }
    public function updateBoardMembers(Board|string $board, array $payload): Board
    {
        return $this->boardRepository->updateMembers($board, $payload);
    }
    public function updateBoardMemberPosition(Board|string $board, array $payload): Board
    {
        return $this->boardRepository->updateMemberPosition($board, $payload);
    }

    public function getCommitteeMembers($committee)
    {
        $filters = [
            'committee_id' => $committee,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Member::class, MemberResource::class, $filters);
    }
    public function fetchCommitteeMember($committee)
    {
        return Member::where('committee_id', $committee)
                     ->where('user_id', Auth::user()->id)->first();
    }
    public function updateCommitteeMembers(Committee|string $committee, array $payload): Committee
    {
        return $this->committeeRepository->updateMembers($committee, $payload);
    }
    public function updateCommitteeMemberPosition(Committee|string $committee, array $payload): Committee
    {
        return $this->committeeRepository->updateMemberPosition($committee, $payload);
    }

}