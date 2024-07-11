<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Module\Member\Position;
use App\Models\Module\Committe\Committee;
use App\Notifications\CommitteeUpdateNotification;
use App\Notifications\CommitteeNewMemberNotification;
use App\Notifications\CommitteeMemberPositionNotification;

class CommitteeObserver
{
        /**
     * Handle the Committee "created" event.
     */
    public function created(Committee $committee): void
    {
        $user = $committee->owner;  // Access the owner directly from the committee instance.
        // dd($committee, $user);

        // Notify the user
        // $user->notify(new CommitteeNewMemberNotification($user, $committee));
    }

    /**
     * Handle the Committee "updated" event.
     */
    public function updated(Committee $committee): void
    {
        if (!empty($committee->tempUserIds)) {
            $this->notifyCommitteeMembers($committee, $committee->tempUserIds);
        }
        if (!empty($committee->tempMemberId)  && !empty($committee->tempMemberPosition)) {
            $this->notifyCommitteeMemberPositionChange($committee, $committee->tempMemberId, $committee->tempMemberPosition);
        }
        if (!empty($committee->tempMemberUpdates)) {
            $this->updateCommitteeMembers($committee, $committee->tempMemberUpdates);
        }
    }

    /**
     * Handle the Committee "deleted" event.
     */

    public function deleted(Committee $committee): void
    {
        //
    }

    /**
     * Handle the Committee "restored" event.
     */
    public function restored(Committee $committee): void
    {
        //
    }

    /**
     * Handle the Committee "force deleted" event.
     */
    public function forceDeleted(Committee $committee): void
    {
        //
    }
    private function notifyCommitteeMemberPositionChange(Committee $committee, string $tempMemberId, string $tempMemberPosition)
    {
        // Updating the member's position based on the mapped position
        $member = $committee->members()->where('id', $tempMemberId)->first();

        if ($member) {
            $member->position_id = $tempMemberPosition;
            $member->save();

            // Optionally, notify the member if there's a significant change or reason to notify
            if ($member->save()) {
                $user = User::find($member->user_id);
                $user->notify(new CommitteeMemberPositionNotification($user, $committee, $tempMemberPosition));
            }
        }
    }

    private function notifyCommitteeMembers(Committee $committee, array $userIds)
    {
        $users = User::whereIn('id', $userIds)->get();
        $updateMessage = "The committee '{$committee->name}' has been updated. Check out what's new!";
        foreach ($users as $user) {
            $user->notify(new CommitteeUpdateNotification($user, $committee, $updateMessage));
        }
    }
    protected function updateCommitteeMembers(Committee $committee, array $newMemberIds)
    {

        $defaultPositionId = Position::where('name', 'Committee Member')->first()->id;
        $SpecificPositionId = Position::where('name', 'Secretary')->first()->id;
        // Fetch existing member IDs for comparison
        $existingMemberIds = $committee->members->pluck('user_id')->toArray();

        // Determine members to add or remove
        $membersToAdd = array_diff($newMemberIds, $existingMemberIds);
        $membersToRemove = array_diff($existingMemberIds, $newMemberIds);

        // Remove members not included in the new list
        foreach ($membersToRemove as $memberId) {
            $committee->members()
                ->where('user_id', $memberId)
                ->where('position_id', '!=', $SpecificPositionId)
                ->delete();
        }

        // Add new members or update existing ones
        foreach ($newMemberIds as $memberId) {
            $member = $committee->members()->firstOrNew(
                ['user_id' => $memberId],
                ['committee_id' => $committee->id]
            );

            // Set position_id to 'Committee Member' if member is new
            $member->position_id = $member->exists ? $member->position_id : $defaultPositionId;
            $member->save();

            // Notify new members
            if ($member->wasRecentlyCreated) {
                $user = User::find($memberId);
                $user->notify(new CommitteeNewMemberNotification($user, $committee));
            }
        }
    }


}
