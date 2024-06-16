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
        // Fetch existing member IDs for comparison
        $existingMemberIds = $board->members->pluck('user_id')->toArray();

        // Determine members to add or remove
        $membersToAdd = array_diff($newMemberIds, $existingMemberIds);
        $membersToRemove = array_diff($existingMemberIds, $newMemberIds);

        // Remove members not included in the new list
        foreach ($membersToRemove as $member_id) {
            $board->members()
                ->where('user_id', $member_id)
                ->where('position_id', '!=',  Position::where('name', 'Secretary')->first()->id,)
                ->delete();
        }

        // Add new members or update existing ones
        foreach ($membersToAdd as $memberId) {
            $member = $board->members()->Create(
                ['board_id' => $board->id, 'user_id' => $memberId],
                ['position_id' => Position::where('name', 'Board Member')->first()->id,] // Assumes a default position enum is used
            );

            // Notify new members
            if ($member->wasRecentlyCreated) {
                $user = User::find($memberId);
                $user->notify(new BoardNewMemberNotification($user, $board));
            }
        }
    }
    // function mapRoleToPosition(string $roleName): string
    // {
    //     // Mapping of role names to PositionEnum cases, all keys are in lowercase
    //     $mapping = [
    //         'system'            => PositionEnum::System->value,
    //         'admin'             => PositionEnum::Admin->value,
    //         'ceo'               => PositionEnum::CEO->value,
    //         'company chairman'  => PositionEnum::CompanyChairman->value,
    //         'company secretary' => PositionEnum::CompanySecretary->value,
    //         'chairperson'       => PositionEnum::Chairperson->value,
    //         'secretary'         => PositionEnum::Secretary->value,
    //         'member'            => PositionEnum::Member->value,
    //         'guest'             => PositionEnum::Guest->value,
    //         'owner'             => PositionEnum::Owner->value,  // Observer maps to Default
    //         'observer'          => PositionEnum::Default->value,  // Observer maps to Default
    //     ];

    //     // Convert the input role name to lowercase to ensure case insensitivity
    //     $normalizedRoleName = strtolower($roleName);

    //     // Return the enum value for the normalized role name or the default value if not found
    //     return $mapping[$normalizedRoleName] ?? PositionEnum::Default->value;
    // }
}