<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Board\Board;
use App\Models\Module\Committe\Committee;

interface CommitteeInterface
{
    public function getAll();
    public function getLatest();
    public function getBoardCommittee($board);
    public function fetchAuthMember(string $committee);

    public function get(Committee|string $committee): Committee;
    public function getMembers(Committee|string $committee): Committee;

    public function create(Board $board, array $payload): Committee;

    public function update(Committee|string $committee, array $payload): Committee;
    public function updateMembers(Committee $committee, array $payload): Committee;
    public function updateMemberPosition(Committee|string $committee, array $payload): Committee;

    public function delete(Committee|string $committee);


}
