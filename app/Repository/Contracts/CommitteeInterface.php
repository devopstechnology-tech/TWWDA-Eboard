<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Committe\Committee;

interface CommitteeInterface
{
    public function getAll();

    public function get(Committee|string $committee): Committee;
    public function fetchAuthMember(string $id);
    public function create(array $payload): Committee;

    public function update(Committee|string $committee, array $payload): Committee;
    public function updatememmbers(Committee|string $committee, array $payload): Committee;

    public function delete(Committee|string $committee): bool;
}
