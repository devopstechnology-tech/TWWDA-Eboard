<?php

namespace App\Observers;

use App\Models\Module\Meeting\Agenda;
use App\Notifications\AgendaAssigneeNotification;

class AgendaObserver
{
    //
    public function created(Agenda $agenda): void
    {
        $this->notifyAssignees($agenda);
    }

    public function updated(Agenda $agenda): void
    {
        // dd($agenda);
        $this->notifyAssignees($agenda);
    }

    private function notifyAssignees(Agenda $agenda): void
    {
        // foreach ($agenda->assignees as $assignee) {
        //     $user = $assignee->user;
        //     $assignee->user->notify(new AgendaAssigneeNotification($user, $agenda));
        // }
    }
}