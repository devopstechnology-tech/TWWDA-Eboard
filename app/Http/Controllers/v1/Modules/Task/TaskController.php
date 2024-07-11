<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Task;

use Illuminate\Http\Response;
use App\Models\Module\Task\Task;
use Illuminate\Http\JsonResponse;
use App\Models\Module\Board\Board;
use App\Http\Controllers\Controller;
use App\Models\Module\Meeting\Meeting;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Module\Committe\Committee;
use App\Repository\Contracts\TaskInterface;

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
    public function updatetask(UpdateTaskRequest $request, Meeting $meeting, Board $board): JsonResponse
    {
        $task = $this->taskRepository->updateTask($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $task, Task::class);
    }
    public function getmeetingtasks($meeting): JsonResponse
    {
        $tasks = $this->taskRepository->getMeetingTasks($meeting);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $tasks, Task::class);
    }
    public function createmeetingtask(CreateTaskRequest $request, Meeting $meeting): JsonResponse
    {
        $task = $this->taskRepository->createMeetingTask($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $task, Task::class);
    }
    
    public function updatemeetingtask(UpdateTaskRequest $request, Meeting $meeting, Task $task): JsonResponse
    {
        $task = $this->taskRepository->updateMeetingTask($meeting, $task, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $task, Task::class);
    }
    //board
    public function getboardtasks($board): JsonResponse
    {
        $tasks = $this->taskRepository->getBoardTasks($board);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $tasks, Task::class);
    }
    public function createboardtask(CreateTaskRequest $request, Board $board): JsonResponse
    {
        $task = $this->taskRepository->createBoardTask($board, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $task, Task::class);
    }
    
    public function updateboardtask(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task = $this->taskRepository->updateBoardTask($task, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $task, Task::class);
    }
    //committee
    public function getcommitteetasks($committee): JsonResponse
    {
        $tasks = $this->taskRepository->getCommitteeTasks($committee);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $tasks, Task::class);
    }
    public function createcommitteetask(CreateTaskRequest $request, Committee $committee): JsonResponse
    {
        $task = $this->taskRepository->createCommitteeTask($committee, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $task, Task::class);
    }
    
    public function updatecommitteetask(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task = $this->taskRepository->updateCommitteeTask($task, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $task, Task::class);
    }




}
