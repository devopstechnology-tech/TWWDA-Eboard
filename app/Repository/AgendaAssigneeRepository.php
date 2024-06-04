<?php

namespace App\Repository;

use App\Repository\BaseRepository;
use App\Models\Module\Meeting\Agenda;
use App\Repository\Contracts\AgendaInterface;
use App\Notifications\AgendaAssigneeNotification;
use App\Models\Module\Meeting\Agenda\AgendaAssignee;
use App\Repository\Contracts\AgendaAssigneeInterface;

class AgendaAssigneeRepository extends BaseRepository implements AgendaAssigneeInterface
{
    private $agendaRepository;

    public function getAgendaRepository(): AgendaInterface
    {
        // Lazily load the AgendaAssigneeRepository when needed
        return $this->agendaRepository ??= resolve(AgendaInterface::class);
    }

    // Implement the methods
    public function create(Agenda|string $agenda, array $payload)
    {
        $memberships = $payload['assignees'];
        $this->getexistingAssignees($agenda);

        foreach ($memberships as $membership) {
            $agendaAssignee = new AgendaAssignee();
            $agendaAssignee->agenda_id = $agenda->id;
            $agendaAssignee->membership_id = $membership;
            $agendaAssignee->save();
        }

        $this->notifiyAssignee($agenda);
    }
    public function getexistingAssignees(Agenda|string $agenda)
    {
        $existingAssignees = AgendaAssignee::where('agenda_id', $agenda->id)->get();

        if ($existingAssignees->isNotEmpty()) {
            $existingAssigneesMap = $existingAssignees->keyBy('membership_id')->toArray();
            $this->deleteonForce($agenda, $existingAssigneesMap);
        }
    }
    public function deleteonForce(Agenda|string $agenda, $existingAssigneesMap)
    {
        foreach ($existingAssigneesMap as $unusedMembershipId => $unusedAssignee) {
            // Optionally delete or deactivate unused assignees
            AgendaAssignee::where('agenda_id', $agenda->id)
                ->where('membership_id', $unusedMembershipId)
                ->forceDelete();  // Or another action as needed
        }
    }

    public function notifiyAssignee(Agenda|string $agenda)
    {
        foreach ($agenda->assignees as $assignee) {
            $user = $assignee->user;
            $assignee->user->notify(new AgendaAssigneeNotification($user, $agenda));
        }
    }
}