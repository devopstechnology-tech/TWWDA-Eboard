<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Committee;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Module\Board\Board;
use App\Http\Controllers\Controller;
use App\Models\Module\Committe\Committee;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Requests\CreateCommitteeRequest;
use App\Http\Requests\UpdateCommitteeRequest;
use App\Repository\Contracts\CommitteeInterface;


class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct(private readonly CommitteeInterface $committeeRepository)
     {
     }
     public function index(): JsonResponse
     {
         // ds("mix me down");
         // dd("mix me down");
         // $this->authorize('viewAny', Committee::class);
         $committee = $this->committeeRepository->getAll();
 
         return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $committee, Committee::class);
     }
     public function latest(): JsonResponse
     {
         // ds("mix me down");
         // dd("mix me down");
         // $this->authorize('viewAny', Committee::class);
         $committee = $this->committeeRepository->getLatest();
 
         return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $committee, Committee::class);
     }
 
     public function show(Committee $committee): JsonResponse
     {
         // $this->authorize('view', [Committee::class, $committee->id]);
         $committee = $this->committeeRepository->get($committee);
 
         return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $committee, Committee::class);
     }
 
     public function store(CreateCommitteeRequest $request, Board $board ): JsonResponse
     {
         // dd('1', $request);
         // $this->authorize('create', [Committee::class]);
         $committee = $this->committeeRepository->create($board, $request->validated());
 
         return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $committee);
     }
 
     public function update(UpdateCommitteeRequest $request, Committee $committee): JsonResponse
     {
         // dd('2',$request, $committee);
         // $this->authorize('update', [Committee::class, $committee->id]);
         $committee = $this->committeeRepository->update($committee, $request->validated());
 
         return $this->response(Response::HTTP_OK, __('messages.record-updated'), $committee);
     }
     public function getmembers(Committee $committee): JsonResponse
     {
         // $this->authorize('update', [Committee::class, $committee->id]);
         $committee = $this->committeeRepository->getMembers($committee);
 
         return $this->response(Response::HTTP_OK, __('messages.record-updated'), $committee);
     }
     public function updatemembers(UpdateMemberRequest $request, Board $board, Committee $committee): JsonResponse
     {
         // $this->authorize('update', [Committee::class, $committee->id]);
         $committee = $this->committeeRepository->updateMembers($board, $committee, $request->validated());
 
         return $this->response(Response::HTTP_OK, __('messages.record-updated'), $committee);
     }
 
     public function destroy(Committee $committee): JsonResponse
     {
         // $this->authorize('delete', [Committee::class, $committee->id]);
         $this->committeeRepository->delete($committee);
 
         return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), null);
     }
}
