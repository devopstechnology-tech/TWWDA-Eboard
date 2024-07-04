<?php

namespace App\Repository\Contracts;

interface PositionInterface
{
    // Define your methods here

    public function getBoardPositions();
    public function getCommitteePositions();
    public function getMeetingPositions();
    public function storePosition(array $payload);
    public function updatePosition($position, array $payload);
    public function activatePosition($position);
    public function deactivatePosition($position);
    public function destroyPosition($position);
    public function ForcedestroyPosition($position);
}