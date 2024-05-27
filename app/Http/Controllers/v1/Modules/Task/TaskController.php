<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Task\Task;
use App\Repository\Contracts\TaskInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(private readonly TaskInterface $taskRepository)
    {
    }
    public function index(): JsonResponse
    {
        $tasks = $this->taskRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $tasks, Task::class);
    }
    public function getmeetingtasks($meeting): JsonResponse
    {
        $tasks = $this->taskRepository->getMeetingTasks($meeting);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $tasks, Task::class);
    }
    public function createmeetingtask(CreateTaskRequest $request, Meeting $meeting, Board $board): JsonResponse
    {
        $task = $this->taskRepository->createMeetingTask($meeting, $board, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $task, Task::class);
    }
    public function updatetask(UpdateTaskRequest $request, Meeting $meeting, Board $board): JsonResponse
    {
        $task = $this->taskRepository->updateTask($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $task, Task::class);
    }
    public function updatemeetingtask(UpdateTaskRequest $request, Meeting $meeting, Board $board, Task $task): JsonResponse
    {
        $task = $this->taskRepository->updateMeetingTask($meeting, $board, $task, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $task, Task::class);
    }
}
