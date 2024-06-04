<?php

namespace App\Repository;

use App\Repository\BaseRepository;
use App\Models\Module\Meeting\Agenda\SubAgenda;
use App\Models\Module\Meeting\Agenda\AgendaAssignee;
use App\Repository\Contracts\SubAgendaAssigneeInterface;

class SubAgendaAssigneeRepository extends BaseRepository implements SubAgendaAssigneeInterface
{
    // Implement the methods
    public function create(SubAgenda|string $subagenda, array $payload)
    {
        $memberships = $payload['assignees'];

        $this->getexistingAssignees($subagenda);

        foreach ($memberships as $membership) {
            $subagendaAssignee = new AgendaAssignee();
            $subagendaAssignee->subagenda_id = $subagenda->id;
            $subagendaAssignee->membership_id = $membership;
            $subagendaAssignee->save();
        }
    }
    public function getexistingAssignees(SubAgenda|string $subagenda)
    {
        $existingAssignees = AgendaAssignee::where('subagenda_id', $subagenda->id)->get();

        if ($existingAssignees->isNotEmpty()) {
            $existingAssigneesMap = $existingAssignees->keyBy('membership_id')->toArray();
            $this->deleteonForce($subagenda, $existingAssigneesMap);
        }
    }
    public function deleteonForce(SubAgenda|string $subagenda, $existingAssigneesMap)
    {
        foreach ($existingAssigneesMap as $unusedMembershipId => $unusedAssignee) {
            // Optionally delete or deactivate unused assignees
            AgendaAssignee::where('subagenda_id', $subagenda->id)
                ->where('membership_id', $unusedMembershipId)
                ->forceDelete();  // Or another action as needed
        }
    }
}