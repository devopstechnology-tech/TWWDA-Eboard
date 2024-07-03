<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\User;
use App\Enums\PositionEnum;
use App\Models\Module\Board\Board;
use App\Models\Module\Member\Position;
use App\Notifications\BoardUpdateNotification;
use App\Notifications\BoardNewMemberNotification;
use App\Notifications\BoardMemberRoleNotification;
use App\Notifications\BoardMemberPositionNotification;


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
        if (!empty($board->tempMemberId)  && !empty($board->tempMemberPosition)) {
            $this->notifyBoardMemberPositionChange($board, $board->tempMemberId, $board->tempMemberPosition);
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
    private function notifyBoardMemberPositionChange(Board $board, string $tempMemberId, string $tempMemberPosition)
    {
        // Updating the member's position based on the mapped position
        $member = $board->members()->where('id', $tempMemberId)->first();

        if ($member) {
            $member->position_id = $tempMemberPosition;
            $member->save();

            // Optionally, notify the member if there's a significant change or reason to notify
            if ($member->save()) {
                $user = User::find($member->user_id);
                $user->notify(new BoardMemberPositionNotification($user, $board, $tempMemberPosition));
            }
        }
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

        $defaultPositionId = Position::where('name', 'Board Member')->first()->id;
        $SpecificPositionId = Position::where('name', 'Secretary')->first()->id;
        // Fetch existing member IDs for comparison
        $existingMemberIds = $board->members->pluck('user_id')->toArray();

        // Determine members to add or remove
        $membersToAdd = array_diff($newMemberIds, $existingMemberIds);
        $membersToRemove = array_diff($existingMemberIds, $newMemberIds);

        // Remove members not included in the new list
        foreach ($membersToRemove as $memberId) {
            $board->members()
                ->where('user_id', $memberId)
                ->where('position_id', '!=', $SpecificPositionId)
                ->delete();
        }

        // Add new members or update existing ones
        foreach ($newMemberIds as $memberId) {
            $member = $board->members()->firstOrNew(
                ['user_id' => $memberId],
                ['board_id' => $board->id]
            );

            // Set position_id to 'Board Member' if member is new
            $member->position_id = $member->exists ? $member->position_id : $defaultPositionId;
            $member->save();

            // Notify new members
            if ($member->wasRecentlyCreated) {
                $user = User::find($memberId);
                $user->notify(new BoardNewMemberNotification($user, $board));
            }
        }
    }
}