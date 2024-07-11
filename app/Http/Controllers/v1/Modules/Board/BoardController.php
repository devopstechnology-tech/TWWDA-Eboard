<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Board;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Module\Board\Board;
use App\Repository\Contracts\BoardInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(private readonly BoardInterface $boardRepository)
    {
    }
    public function index(): JsonResponse
    {
        // ds("mix me down");
        // dd("mix me down");
        // $this->authorize('viewAny', Board::class);
        $board = $this->boardRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $board, Board::class);
    }
    public function latest(): JsonResponse
    {
        // ds("mix me down");
        // dd("mix me down");
        // $this->authorize('viewAny', Board::class);
        $board = $this->boardRepository->getLatest();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $board, Board::class);
    }

    public function show(Board $board): JsonResponse
    {
        // $this->authorize('view', [Board::class, $board->id]);
        $board = $this->boardRepository->get($board);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $board, Board::class);
    }

    public function store(CreateBoardRequest $request): JsonResponse
    {
        // dd('1', $request);
        // $this->authorize('create', [Board::class]);
        $board = $this->boardRepository->create($request->validated());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $board);
    }

    public function update(UpdateBoardRequest $request, Board $board): JsonResponse
    {
        // dd('2',$request, $board);
        // $this->authorize('update', [Board::class, $board->id]);
        $board = $this->boardRepository->update($board, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $board);
    }
    public function getmembers(Board $board): JsonResponse
    {
        // $this->authorize('update', [Board::class, $board->id]);
        $board = $this->boardRepository->getMembers($board);

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $board);
    }
    public function updatemembers(UpdateMemberRequest $request, Board $board): JsonResponse
    {
        // $this->authorize('update', [Board::class, $board->id]);
        $board = $this->boardRepository->updateMembers($board, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $board);
    }

    public function destroy(Board $board): JsonResponse
    {
        // $this->authorize('delete', [Board::class, $board->id]);
        $this->boardRepository->delete($board);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), null);
    }
}
