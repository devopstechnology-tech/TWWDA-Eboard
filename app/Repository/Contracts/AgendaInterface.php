<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\Module\Meeting\Agenda;
use App\Models\Module\Meeting\Agenda\SubAgenda;

interface AgendaInterface
{
    // Define your methods here
    public function getAll();

    public function getlatestMeetingAgendas();
    public function AcceptLatestMeetingAgendas($oldmeeting, $newmeeting);
    public function getMeetingAgendas($meeting);
    public function get(Agenda|string $agenda): Agenda;
    public function create($meeting, array $payload);
    public function createSubAgenda($meeting, array $payload);
    public function updateSubAgenda($subagenda, array $payload);

    public function update(Agenda|string $agenda, array $payload): Agenda;

    public function delete(Agenda|string $agenda): bool;
    public function deleteagenda(Agenda|string $agenda): bool;
    public function deletesubagenda(SubAgenda|string $agenda): bool;
}