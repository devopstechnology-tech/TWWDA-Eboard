<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Board\Board;
use App\Models\Module\Member\Member;
use App\Models\Module\Committe\Committee;

interface MemberInterface
{
    // Define your methods here
    public function getAll();
    public function getBoardMembers($member);
    public function fetchBoardMember($board);
    public function getBoardCollectionMembers($board);
    
    public function updateBoardMembers(Board|string $board, array $payload): Board;
    public function updateBoardMemberPosition(Board|string $board, array $payload): Board;
    //committee
    public function getCommitteeMembers($member);
    public function fetchCommitteeMember($committee);
    public function getCommitteeCollectionMembers($committee);
    public function updateCommitteeMembers(Committee|string $committee, array $payload): Committee;
    public function updateCommitteeMemberPosition(Committee|string $committee, array $payload): Committee;
    
    

}