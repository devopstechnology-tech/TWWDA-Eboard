<?php

namespace App\Observers;

use App\Models\User;
use App\Enums\PositionEnum;
use App\Models\Module\Board\Board;
use App\Notifications\BoardUpdateNotification;
use App\Notifications\BoardNewMemberNotification;


class BoardObserver
{
    /**
     * Handle the Board "created" event.
     */
    public function created(Board $board): void
    {
        $user = $board->owner;  // Access the owner directly from the board instance.
        // dd($board, $user);

        // Notify the user
        // $user->notify(new BoardNewMemberNotification($user, $board));
    }

    /**
     * Handle the Board "updated" event.
     */
    public function updated(Board $board): void
    {
        if (!empty($board->tempUserIds)) {
            $this->notifyBoardMembers($board, $board->tempUserIds);
        }
        if (!empty($board->tempMemberUpdates)) {
            $this->updateBoardMembers($board, $board->tempMemberUpdates);
        }
    }

    /**
     * Handle the Board "deleted" event.
     */

    public function deleted(Board $board): void
    {
        //
    }

    /**
     * Handle the Board "restored" event.
     */
    public function restored(Board $board): void
    {
        //
    }

    /**
     * Handle the Board "force deleted" event.
     */
    public function forceDeleted(Board $board): void
    {
        //
    }
    private function notifyBoardMembers(Board $board, array $userIds)
    {
        $users = User::whereIn('id', $userIds)->get();
        $updateMessage = "The board '{$board->name}' has been updated. Check out what's new!";
        foreach ($users as $user) {
            $user->notify(new BoardUpdateNotification($user, $board, $updateMessage));
        }
    }
    protected function updateBoardMembers(Board $board, array $newMemberIds)
    {
        // Fetch existing member IDs for comparison
        $existingMemberIds = $board->members->pluck('user_id')->toArray();

        // Determine members to add or remove
        $membersToAdd = array_diff($newMemberIds, $existingMemberIds);
        $membersToRemove = array_diff($existingMemberIds, $newMemberIds);

        // Remove members not included in the new list
        foreach ($membersToRemove as $member_id) {
            $board->members()
                ->where('user_id', $member_id)
                ->where('position', '!=', PositionEnum::Owner->value)
                ->delete();
        }

        // Add new members or update existing ones
        foreach ($membersToAdd as $memberId) {
            $member = $board->members()->Create(
                ['board_id' => $board->id, 'user_id' => $memberId],
                ['position' => PositionEnum::Default->value] // Assumes a default position enum is used
            );

            // Notify new members
            if ($member->wasRecentlyCreated) {
                $user = User::find($memberId);
                $user->notify(new BoardNewMemberNotification($user, $board));
            }
        }
    }
}