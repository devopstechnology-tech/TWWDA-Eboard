<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Contracts\BoardMemberInterface;

class BoardMemberRepository extends BaseRepository implements BoardMemberInterface
{
    // Implement the methods
    public function getAll();

    public function get(BoardMember|string $boardMember): BoardMember;

    public function create(Board|string $board, array $payload): void;
    public function updateMembers(Board|string $board, array $payload): void;
    public function update(Board|string $board, array $payload): Board;

    public function delete(BoardMember|string $boardMember): bool;


}
