<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Resources\CommitteeResource;
use App\Models\Module\Committe\Committee;
use App\Repository\Contracts\CommitteeInterface;
use App\Repository\Contracts\CommitteeMemberInterface;
use Illuminate\Support\Facades\Auth;

class CommitteeRepository extends BaseRepository implements CommitteeInterface
{
    public function __construct(private readonly CommitteeMemberInterface $committeeMemberRepository)
    {
    }
    public function getAll()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical CommitteeResource for transformation
        $filters = [
            'owner_id' => Auth::user()->id,
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
    ];
        return $this->indexResource(Committee::class, CommitteeResource::class, $filters);
    }

    public function get(Committee|string $committee): Committee
    {
        if (!($committee instanceof Committee)) {
            $committee = Committee::findOrFail($committee);
        }

        return $committee;
    }
    public function fetchAuthMember(string $id)
    {
        $committee = Committee::findOrFail($id);
        $member = $committee->members()->where('user_id', Auth::user()->id)->first();
        return $member;
    }

    public function create(array $payload): Committee
    {
        $committee = Committee::firstOrCreate($payload);
        $committee->owner_id = Auth::user()->id;
        // $committee->cover = $payload['cover'];
        $committee->save();
        if($committee) {
            $this->committeeMemberRepository->create($committee, $payload);
        }
        return $committee;
    }

    public function update(Committee|string $committee, array $payload): Committee
    {
        if (!($committee instanceof Committee)) {
            $committee = Committee::findOrFail($committee);
        }
        $committee->update($payload);
        $committee->save();
        if($committee) {
            $this->committeeMemberRepository->create($committee, $payload);
        }

        return $committee;
    }
    public function updatememmbers(Committee|string $committee, array $payload): Committee
    {
        if (!($committee instanceof Committee)) {
            $committee = Committee::findOrFail($committee);
        }

        if($committee) {
            $this->committeeMemberRepository->updateMembers($committee, $payload);
        }

        return $committee;
    }

    public function delete(Committee|string $committee): bool
    {
        if (!($committee instanceof Committee)) {
            $committee = Committee::findOrFail($committee);
        }

        return $committee->delete();
    }// Implement the methods
}
