<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Meeting;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMinuteRequest;
use App\Http\Requests\CreateSubMinuteRequest;
use App\Http\Requests\UpdateMinuteRequest;
use App\Http\Requests\UpdateSubMinuteRequest;
use App\Models\Module\Meeting\Minute;
use App\Repository\Contracts\MinuteInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MinuteController extends Controller
{
    //
    // meetingminutes
    public function __construct(private readonly MinuteInterface $minuteRepository)
    {
    }
    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', Minute::class);
        $minute = $this->minuteRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $minute, Minute::class);
    }
    public function meetingminutes($meeting): JsonResponse
    {
        // $this->authorize('viewAny', Minute::class);
        $minute = $this->minuteRepository->getMeetingMinutes($meeting);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $minute, Minute::class);
    }

    public function show(Minute $minute): JsonResponse
    {
        // $this->authorize('view', [Minute::class, $minute->id]);
        $minute = $this->minuteRepository->get($minute);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $minute, Minute::class);
    }

    public function store(CreateMinuteRequest $request, $meeting): JsonResponse
    {
        // $this->authorize('create', [Minute::class]);
        $minute = $this->minuteRepository->create($meeting, $request->validated());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $minute, Minute::class);
    }

    public function update(UpdateMinuteRequest $request, $minute): JsonResponse
    {
        // dd($minute);
        // $this->authorize('update', [Minute::class, $minute->id]);
        $minute = $this->minuteRepository->update($minute, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $minute);
    }
    public function createsubminute(CreateSubMinuteRequest $request, $meeting): JsonResponse
    {
        // $this->authorize('create', [Minute::class]);
        $minute = $this->minuteRepository->createsubminute($meeting, $request->validated());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $minute, Minute::class);
    }
    public function updatesubminute(UpdateSubMinuteRequest $request, $minute): JsonResponse
    {
        // dd($minute);
        // $this->authorize('update', [Minute::class, $minute->id]);
        $minute = $this->minuteRepository->updatesubminute($minute, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $minute);
    }

    public function destroy(Minute $minute): JsonResponse
    {
        $this->authorize('delete', [Minute::class, $minute->id]);
        $this->minuteRepository->delete($minute);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), null);
    }


}
