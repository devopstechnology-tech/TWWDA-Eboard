<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Http\Resources\ModificationResource;
use App\Models\System\Modification;

interface ModificationInterface
{
    public function getAll();

    public function get(Modification|string $modification): ModificationResource;

    public function create(array $payload): ModificationResource;

    public function update(Modification|string $modification, array $payload): ModificationResource;

    public function delete(Modification|string $modification): bool;

    public function disapprove(Modification|string $modification, string $reason): bool;

    public function approve(Modification|string $modification, string $reason): bool;
}
