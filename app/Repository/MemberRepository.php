<?php

declare(strict_types=1);

namespace App\Repository;

use App\Http\Resources\MemberResource;
use App\Models\Module\Board\Board;
use App\Models\Module\Member\Member;
use App\Repository\Contracts\BoardInterface;
use App\Repository\Contracts\MemberInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MemberRepository extends BaseRepository implements MemberInterface
{
    public function __construct(private readonly BoardInterface $boardRepository)
    {
    }
    public function relationships()
    {
        return [
            'board',
            'committee',
            'guest',
            'user',
        ];
    }
    public function getAll()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical MemberResource for transformation
        $filters = [
            'with' => $this->relationships(),
            'user_id' => Auth::user()->id,
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Member::class, MemberResource::class, $filters);
    }
    public function getBoardMembers($board)
    {
        $filters = [
            'board_id' => $board,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Member::class, MemberResource::class, $filters);
    }
    public function updateMembers(Board|string $board, array $payload): Board
    {
        return $this->boardRepository->updateMembers($board, $payload);
    }

    // public function get(Member|string $member): Member
    // {
    //     if (!($member instanceof Member)) {
    //         $member = Member::findOrFail($member);
    //     }

    //     return $member;
    // }

    // public function create(Member|string $member, array $payload): void
    // {
    //     if (!($member instanceof Member)) {
    //         $member = Member::findOrFail($member);
    //     }
    //     if (Auth::check()) {
    //         $userId = Auth::id();// Ensure $member is a valid Member model instance
    //         // Sync the user to the member without detaching existing ones
    //         $member->members()->syncWithoutDetaching([$userId]);
    //     }
    // }

    // public function update(Member|string $member, array $payload): Member
    // {
    //     if (!($member instanceof Member)) {
    //         $member = Member::findOrFail($member);
    //     }
    //     Log::info('Array content 2:', ['member' => $member]);


    //     // // Ensure we have an authenticated user before proceeding
    //     // if (!Auth::check()) {
    //     // //     return response()->json(['message' => 'User not authenticated'], 401);
    //     // // }
    //     //     $userId = Auth::id(); // Get the current authenticated user's ID
    //     //     $userIds = $payload['members'];

    //     // //     // Filter out null values and ensure unique IDs
    //     //     $userIds = array_unique(array_filter($userIds, function ($id) {
    //     //         return !is_null($id) && $id !== '';
    //     //     }));

    //     //     Log::info('Array content 2:', $userIds);
    //     // //     // Ensure the current user's ID is included
    //     //     if (!in_array($userId, $userIds)) {
    //     //         $userIds[] = $userId;
    //     //     }
    //     // //     // Sync the member associations, including the current user
    //     //     $member->members()->sync($userIds);

    //     return $member;
    // }
    // public function updateMembers(Member|string $member, array $payload): void
    // {
    //     if (!($member instanceof Member)) {
    //         $member = Member::findOrFail($member);
    //     }

    //     // Ensure we have an authenticated user before proceeding
    //     if (!Auth::check()) {
    //         //     return response()->json(['message' => 'User not authenticated'], 401);
    //     }
    //     $userId = Auth::id(); // Get the current authenticated user's ID
    //     $userIds = $payload['members'];

    //     //     // Filter out null values and ensure unique IDs
    //     $userIds = array_unique(array_filter($userIds, function ($id) {
    //         return !is_null($id) && $id !== '';
    //     }));

    //     Log::info('Array content 2:', $userIds);
    //     //     // Ensure the current user's ID is included
    //     if (!in_array($userId, $userIds)) {
    //         $userIds[] = $userId;
    //     }
    //     //     // Sync the member associations, including the current user
    //     $member->members()->sync($userIds);
    // }

    // public function delete(Member|string $member): bool
    // {
    //     if (!($member instanceof Member)) {
    //         $member = Member::findOrFail($member);
    //     }

    //     return $member->delete();
    // }

}