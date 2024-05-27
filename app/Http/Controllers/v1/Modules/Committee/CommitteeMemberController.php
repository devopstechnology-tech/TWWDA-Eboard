<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\Committee;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommitteeMemberRequest;
use App\Http\Requests\UpdateCommitteeMemberRequest;
use App\Models\Module\Committe\CommitteeMember;
use App\Repository\Contracts\CommitteeMemberInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CommitteeMemberController extends Controller
{
    public function __construct(private readonly CommitteeMemberInterface $committeeMemberRepository)
    {
    }

    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', CommitteeMember::class);
        $committeeMember = $this->committeeMemberRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $committeeMember, CommitteeMember::class);
    }

    public function show(CommitteeMember $committeeMember): JsonResponse
    {
        // $this->authorize('view', [CommitteeMember::class, $committeeMember->id]);
        $committeeMember = $this->committeeMemberRepository->get($committeeMember);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $committeeMember, CommitteeMember::class);
    }

    public function store(CreateCommitteeMemberRequest $request): JsonResponse
    {
        // $this->authorize('create', [CommitteeMember::class]);
        $committeeMember = $this->committeeMemberRepository->create($request->validated());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $committeeMember);
    }

    public function update(UpdateCommitteeMemberRequest $request, $committee): JsonResponse
    {
        // $this->authorize('update', [CommitteeMember::class, $committeeMember->id]);
        // Log::info('Array content:', $committee);
        $committeeMember = $this->committeeMemberRepository->update($committee, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $committeeMember);
    }

    public function destroy(CommitteeMember $committeeMember): JsonResponse
    {
        $this->authorize('delete', [CommitteeMember::class, $committeeMember->id]);
        $this->committeeMemberRepository->delete($committeeMember);

        return $this->response(Response::HTTP_NO_CONTENT, __('messages.record-deleted'), null);
    }

}
