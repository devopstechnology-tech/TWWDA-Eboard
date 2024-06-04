<?php

namespace App\Repository\Contracts;

use App\Models\Module\Meeting\Agenda;
use App\Models\Module\Meeting\Agenda\AgendaAssignee;

interface AgendaAssigneeInterface
{
    // Define your methods here
    public function create(Agenda|string $agenda, array $payload);
    public function getexistingAssignees(Agenda|string $agenda);
}