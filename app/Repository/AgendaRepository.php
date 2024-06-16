<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\BaseRepository;
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
            'schedule',
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
    public function getScheduleAgendas($schedule)
    {
        $filters = [
            'schedule_id' => $schedule,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Agenda::class, AgendaResource::class, $filters);
    }
    public function getLatestScheduleAgendas()
    {
        // Get the latest agenda by creation date
        $latestAgenda = Agenda::orderBy('created_at', 'desc')->first();

        // Define filters only if latestAgenda is found
        $filters = [];
        if ($latestAgenda) {
            $filters = [
                'schedule_id' => $latestAgenda->schedule_id,
                'with' => $this->relationships(),
                'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
            ];
        }

        // Return the filtered agenda resource or an empty collection
        return $this->indexResource(Agenda::class, AgendaResource::class, $filters);
    }

    // Implement the methods

    public function AcceptLatestScheduleAgendas($oldschedule, $newschedule)
    {
        // dd($payload);
        $agendas = Agenda::with($this->relationships())->where('schedule_id', $oldschedule)->get()->toArray();
        // $subagendas = SubAgenda::where('agenda_id', $oldschedule)->get()->pluck('title')->toArray();

        foreach ($agendas as $oldagenda) {
            $agenda = new Agenda();
            $agenda->title = $oldagenda['title'];
            $agenda->schedule_id  = $newschedule;
            $agenda->save();

            foreach ($agenda->children as $child) {
                $newSubAgenda = new SubAgenda();
                $newSubAgenda->title = $child->title;
                $newSubAgenda->agenda_id = $agenda->id;
                $newSubAgenda->save();
            }
        }
    }
    public function create($schedule, array $payload)
    {
        // dd($payload);
        $agenda = new Agenda();
        $agenda->title       = $payload['title'];
        $agenda->schedule_id  = $schedule;
        //  $agenda->duration    = $payload['duration'];
        //  $agenda->description = !empty($payload['description'])? $payload['description']: null;
        $agenda->save();
        return $agenda;
    }

    public function update($agenda, array $payload): Agenda
    {
        $agenda = Agenda::findOrFail($payload['agenda_id']);

        $agenda->title       = $payload['title'];
        $agenda->schedule_id  = $payload['schedule_id'];
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
    public function createSubAgenda($schedule, array $payload)
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
