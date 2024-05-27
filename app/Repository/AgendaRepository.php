<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Resources\AgendaResource;
use App\Models\Module\Meeting\Agenda;
use App\Models\Module\Meeting\Agenda\SubAgenda;
use App\Repository\Contracts\AgendaInterface;
use Illuminate\Support\Facades\Auth;

class AgendaRepository extends BaseRepository implements AgendaInterface
{
    // Implement the methods
    // Implement the methods
    //  public function __construct(private readonly ScheduleInterface $scheduleRepository)
    //  {
    //  }
    public function relationships()
    {
        return [
            'meeting',
            'children.assignees',
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

    // Implement the methods

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
        $updated = $agenda->assignees()->sync($payload['assignees']);

        return $agenda;
    }
    public function createSubAgenda($meeting, array $payload)
    {
        // dd($payload);
        $agenda = Agenda::findOrFail($payload['agenda_id']);
        if($agenda) {
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

        $updated = $subagenda->assignees()->sync($payload['assignees']);

        return $subagenda;
    }
    public function delete(Agenda|string $agenda): bool
    {
        if (!($agenda instanceof Agenda)) {
            $agenda = Agenda::findOrFail($agenda);
        }

        return $agenda->delete();
    }// Implement the methods



}
