<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Committe\Committee;
use App\Models\Module\Committe\CommitteeMember;

interface CommitteeMemberInterface
{
    // Define your methods here
    public function getAll();

    public function get(CommitteeMember|string $committeeMember): CommitteeMember;

    public function create(Committee|string $committee, array $payload): void;
    public function updateMembers(Committee|string $committee, array $payload): void;
    public function update(Committee|string $committee, array $payload): Committee;

    public function delete(CommitteeMember|string $committeeMember): bool;
}
