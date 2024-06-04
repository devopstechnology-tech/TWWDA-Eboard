<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Support\Facades\Auth;
use App\Models\Module\Meeting\Agenda;
use App\Http\Resources\AgendaResource;
use App\Repository\Contracts\AgendaInterface;
use App\Models\Module\Meeting\Agenda\SubAgenda;
use App\Repository\Contracts\AgendaAssigneeInterface;
use App\Repository\Contracts\SubAgendaAssigneeInterface;

class AgendaRepository extends BaseRepository implements AgendaInterface
{
    private $agendaassigneeRepository;
    private $subagendaassigneeRepository;

    public function getAgendaAssigneeRepository(): AgendaAssigneeInterface
    {
        // Lazily load the AgendaassigneeRepository when needed
        return $this->agendaassigneeRepository ??= resolve(AgendaAssigneeInterface::class);
    }
    public function getSubAgendaAssigneeRepository(): SubAgendaAssigneeInterface
    {
        // Lazily load the AgendaassigneeRepository when needed
        return $this->subagendaassigneeRepository ??= resolve(SubAgendaAssigneeInterface::class);
    }


    public function relationships()
    {
        return [
            'meeting',
            'children.assignees.user',
            'assignees.user',
            'assignees.member',
        ];
    }
    public function getAll()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical AgendaResource for transformation
        $filters = [
            'owner_id' => Auth::user()->id,
            'with' => $this->relationships(),
        ];


        return $this->indexResource(Agenda::class, AgendaResource::class, $filters);
    }

    public function get(Agenda|string $agenda): Agenda
    {
        if (!($agenda instanceof Agenda)) {
            $agenda = Agenda::findOrFail($agenda);
        }

        return $agenda;
    }
    public function getMeetingAgendas($meeting)
    {
        $filters = [
            'meeting_id' => $meeting,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Agenda::class, AgendaResource::class, $filters);
    }
    public function getlatestMeetingAgendas()
    {
        $latestAgenda = Agenda::with($this->relationships())->orderBy('created_at', 'desc')->first();
        $filters = [
            'meeting_id' => $latestAgenda->meeting_id,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Agenda::class, AgendaResource::class, $filters);
    }

    // Implement the methods

    public function AcceptLatestMeetingAgendas($oldmeeting, $newmeeting)
    {
        // dd($payload);
        $agendas = Agenda::with($this->relationships())->where('meeting_id', $oldmeeting)->get()->toArray();
        // $subagendas = SubAgenda::where('agenda_id', $oldmeeting)->get()->pluck('title')->toArray();

        foreach ($agendas as $oldagenda) {
            $agenda = new Agenda();
            $agenda->title = $oldagenda['title'];
            $agenda->meeting_id  = $newmeeting;
            $agenda->save();

            foreach ($agenda->children as $child) {
                $newSubAgenda = new SubAgenda();
                $newSubAgenda->title = $child->title;
                $newSubAgenda->agenda_id = $agenda->id;
                $newSubAgenda->save();
            }
        }
    }
    public function create($meeting, array $payload)
    {
        // dd($payload);
        $agenda = new Agenda();
        $agenda->title       = $payload['title'];
        $agenda->meeting_id  = $meeting;
        //  $agenda->duration    = $payload['duration'];
        //  $agenda->description = !empty($payload['description'])? $payload['description']: null;
        $agenda->save();
        return $agenda;
    }

    public function update($agenda, array $payload): Agenda
    {
        $agenda = Agenda::findOrFail($payload['agenda_id']);

        $agenda->title       = $payload['title'];
        $agenda->meeting_id  = $payload['meeting_id'];
        $agenda->duration    = $payload['duration'];
        $agenda->description = $payload['description'];
        $agenda->save();
        $agenda->touch();
        // $updated = $agenda->assignees()->sync($payload['assignees']);
        if ($agenda->touch()) {
            $this->getAgendaAssigneeRepository()->create($agenda, $payload);
        }
        return $agenda;
    }
    public function createSubAgenda($meeting, array $payload)
    {
        // dd($payload);
        $agenda = Agenda::findOrFail($payload['agenda_id']);
        if ($agenda) {
            $agenda->children()->create([
                'title'       => $payload['title'],
                'agenda_id'   => $payload['agenda_id'],
            ]);
        }
        return $agenda;
    }
    public function updateSubAgenda($subagenda, array $payload)
    {
        $subagenda = SubAgenda::findOrFail($payload['agenda_id']);

        $subagenda->title       = $payload['title'];
        $subagenda->duration    = $payload['duration'];
        $subagenda->description = $payload['description'];
        $subagenda->save();
        $subagenda->touch();

        if ($subagenda->touch()) {
            $this->getSubAgendaAssigneeRepository()->create($subagenda, $payload);
        }

        return $subagenda;
    }
    public function delete(Agenda|string $agenda): bool
    {
        if (!($agenda instanceof Agenda)) {
            $agenda = Agenda::findOrFail($agenda);
        }

        return $agenda->delete();
    } // Implement the methods
    public function deleteagenda(Agenda|string $agenda): bool
    {
        if (!($agenda instanceof Agenda)) {
            $agenda = Agenda::findOrFail($agenda);
        }
        if ($agenda) {
            $this->getAgendaAssigneeRepository()->getexistingAssignees($agenda);
        }

        return $agenda->forceDelete();
    } // Implement the methods
    public function deletesubagenda(SubAgenda|string $subagenda): bool
    {
        if (!($subagenda instanceof SubAgenda)) {
            $subagenda = SubAgenda::findOrFail($subagenda);
        }
        if ($subagenda) {
            $this->getSubAgendaAssigneeRepository()->getexistingAssignees($subagenda);
        }
        return $subagenda->forceDelete();
    } // Implement the methods
}