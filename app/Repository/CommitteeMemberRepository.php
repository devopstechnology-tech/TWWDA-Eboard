<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Module\Committe\Committee;
use App\Models\Module\Committe\CommitteeMember;
use App\Repository\Contracts\CommitteeMemberInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommitteeMemberRepository extends BaseRepository implements CommitteeMemberInterface
{
    public function getAll()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical CommitteeMemberResource for transformation
        $filters = [
            'user_id' => Auth::user()->id,
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
    ];
        return $this->indexResource(CommitteeMember::class, $filters);
    }

    public function get(CommitteeMember|string $committeeMember): CommitteeMember
    {
        if (!($committeeMember instanceof CommitteeMember)) {
            $committeeMember = CommitteeMember::findOrFail($committeeMember);
        }

        return $committeeMember;
    }

    public function create(Committee|string $committee, array $payload): void
    {
        if (!($committee instanceof Committee)) {
            $committee = Committee::findOrFail($committee);
        }
        if (Auth::check()) {
            $userId = Auth::id();// Ensure $committee is a valid Committee model instance
            // Sync the user to the committee without detaching existing ones
            $committee->members()->syncWithoutDetaching([$userId]);
        }
    }

    public function update(Committee|string $committee, array $payload): Committee
    {
        if (!($committee instanceof Committee)) {
            $committee = Committee::findOrFail($committee);
        }
        Log::info('Array content 2:', ['committee' => $committee]);




        // // Ensure we have an authenticated user before proceeding
        // if (!Auth::check()) {
        // //     return response()->json(['message' => 'User not authenticated'], 401);
        // // }
        //     $userId = Auth::id(); // Get the current authenticated user's ID
        //     $userIds = $payload['members'];

        // //     // Filter out null values and ensure unique IDs
        //     $userIds = array_unique(array_filter($userIds, function ($id) {
        //         return !is_null($id) && $id !== '';
        //     }));

        //     Log::info('Array content 2:', $userIds);
        // //     // Ensure the current user's ID is included
        //     if (!in_array($userId, $userIds)) {
        //         $userIds[] = $userId;
        //     }
        // //     // Sync the member associations, including the current user
        //     $committee->members()->sync($userIds);

        return $committee;
    }
    public function updateMembers(Committee|string $committee, array $payload): void
    {
        if (!($committee instanceof Committee)) {
            $committee = Committee::findOrFail($committee);
        }

        // Ensure we have an authenticated user before proceeding
        if (!Auth::check()) {
            //     return response()->json(['message' => 'User not authenticated'], 401);
        }
        $userId = Auth::id(); // Get the current authenticated user's ID
        $userIds = $payload['members'];

        //     // Filter out null values and ensure unique IDs
        $userIds = array_unique(array_filter($userIds, function ($id) {
            return !is_null($id) && $id !== '';
        }));

        Log::info('Array content 2:', $userIds);
        //     // Ensure the current user's ID is included
        if (!in_array($userId, $userIds)) {
            $userIds[] = $userId;
        }
        //     // Sync the member associations, including the current user
        $committee->members()->sync($userIds);
    }

    public function delete(CommitteeMember|string $committeeMember): bool
    {
        if (!($committeeMember instanceof CommitteeMember)) {
            $committeeMember = CommitteeMember::findOrFail($committeeMember);
        }

        return $committeeMember->delete();
    }
}
