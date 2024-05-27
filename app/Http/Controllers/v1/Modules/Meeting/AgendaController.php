<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAgendaRequest;
use App\Http\Requests\CreateSubAgendaRequest;
use App\Http\Requests\UpdateAgendaRequest;
use App\Http\Requests\UpdateSubAgendaRequest;
use App\Models\Module\Meeting\Agenda;
use App\Repository\Contracts\AgendaInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AgendaController extends Controller
{
    public function __construct(private readonly AgendaInterface $agendaRepository)
    {
    }
    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', Agenda::class);
        $agenda = $this->agendaRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $agenda, Agenda::class);
    }
    public function meetingagendas($meeting): JsonResponse
    {
        // $this->authorize('viewAny', Agenda::class);
        $agenda = $this->agendaRepository->getMeetingAgendas($meeting);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $agenda, Agenda::class);
    }

    public function show(Agenda $agenda): JsonResponse
    {
        // $this->authorize('view', [Agenda::class, $agenda->id]);
        $agenda = $this->agendaRepository->get($agenda);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $agenda, Agenda::class);
    }

    public function store(CreateAgendaRequest $request, $meeting): JsonResponse
    {
        // $this->authorize('create', [Agenda::class]);
        $agenda = $this->agendaRepository->create($meeting, $request->validated());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $agenda, Agenda::class);
    }
    public function createsubagenda(CreateSubAgendaRequest $request, $meeting): JsonResponse
    {
        // $this->authorize('create', [Agenda::class]);
        $agenda = $this->agendaRepository->createSubAgenda($meeting, $request->validated());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $agenda, Agenda::class);
    }

    public function update(UpdateAgendaRequest $request, $agenda): JsonResponse
    {

        // $this->authorize('update', [Agenda::class, $agenda->id]);
        $agenda = $this->agendaRepository->update($agenda, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $agenda);
    }
    public function updatesubagenda(UpdateSubAgendaRequest $request, $agenda): JsonResponse
    {
        // dd('2', $agenda);
        // $this->authorize('update', [Agenda::class, $agenda->id]);
        $agenda = $this->agendaRepository->updateSubAgenda($agenda, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $agenda);
    }

    public function destroy(Agenda $agenda): JsonResponse
    {
        $this->authorize('delete', [Agenda::class, $agenda->id]);
        $this->agendaRepository->delete($agenda);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), null);
    }


}
