<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Board\Board;

interface BoardInterface
{
    public function getAll();
    public function fetchAuthMember(string $board);

    public function get(Board|string $board): Board;
    public function getMembers(Board|string $board): Board;

    public function create(array $payload): Board;

    public function update(Board|string $board, array $payload): Board;
    public function updateMembers(Board|string $board, array $payload): Board;

    public function delete(Board|string $board): bool;


}
