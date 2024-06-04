<?php

namespace App\Repository\Contracts;

use App\Models\Module\Meeting\Agenda\SubAgenda;

interface SubAgendaAssigneeInterface
{
    // Define your methods here
    public function create(SubAgenda|string $agenda, array $payload);
    public function getexistingAssignees(SubAgenda|string $subagenda);
}