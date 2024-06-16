<?php

namespace App\Http\Controllers\v1\Modules\Member;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Module\Member\Position;
use App\Http\Requests\CreatePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Repository\Contracts\PositionInterface;

class PositionController extends Controller
{
    //
    //
    public function __construct(private readonly PositionInterface $positionRepository)
    {
    }
    public function index(): JsonResponse
    {
        $positions = $this->positionRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $positions, Position::class);
    }

    public function store(CreatePositionRequest $request): JsonResponse
    {
        $position = $this->positionRepository->storePosition($request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $position, Position::class);
    }
    public function update(UpdatePositionRequest $request, Position $position): JsonResponse
    {
        $position = $this->positionRepository->updatePosition($position, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $position, Position::class);
    }
    public function activate($position): JsonResponse
    {
        $position = $this->positionRepository->activatePosition($position);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $position, Position::class);
    }
    public function deactivate($position): JsonResponse
    {
        // dd($position);
        $position = $this->positionRepository->deactivatePosition($position);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $position, Position::class);
    }

    public function destroy(Position $position): JsonResponse
    {
        $position = $this->positionRepository->destroyPosition($position);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $position, Position::class);
    }
    public function forcedestroy(Position $position): JsonResponse
    {
        $position = $this->positionRepository->ForcedestroyPosition($position);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $position, Position::class);
    }
}