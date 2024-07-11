<?php

namespace App\Repository\Contracts;

use App\Models\System\Almanac;

interface AlmanacInterface
{
    // Define your methods here
    public function getAll();
    public function getLatest();
    public function importAlmanac(array $payload);
    public function createAlmanac(array $payload): Almanac;
    public function updateAlmanac(Almanac|string $almanac, array $payload): Almanac;
    public function approveAlmanac(Almanac|string $almanac): Almanac;
    public function markHeldAlmanac(Almanac|string $almanac): Almanac;
    public function markCancelledAlmanac(Almanac|string $almanac): Almanac;
    public function markPostponedAlmanac(Almanac|string $almanac): Almanac;
    public function deleteAlmanac(Almanac|string $almanac): Almanac;
}
