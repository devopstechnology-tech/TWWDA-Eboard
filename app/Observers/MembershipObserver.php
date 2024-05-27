<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Module\Board\Board;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Membership;
use App\Notifications\MeetingNewMembershipNotification;



class MembershipObserver
{
    /**
     * Handle the Membership "created" event.
     */

    public function created(Membership $membership): void
    {
        $meeting = $membership->meeting;  // Note: Use property access if meeting() is a relationship
        $board = null;
        if ($meeting) {
            $board = $meeting->board();  // Make sure this calls your board() method correctly
        }

        if ($board) {;
            $this->notifyMembershipMembers($membership, $meeting, $board);
        }
    }

    /**
     * Handle the Membership "updated" event.
     */
    public function updated(Membership $membership): void
    {
        $meeting = $membership->meeting;  // Note: Use property access if meeting() is a relationship
        $board = null;
        if ($meeting) {
            $board = $meeting->board();  // Make sure this calls your board() method correctly
        }

        if ($board) {
            $this->notifyMembershipMembers($membership, $meeting, $board);
        }
    }

    /**
     * Handle the Membership "deleted" event.
     */
    public function deleted(Membership $membership): void
    {
        //
    }

    /**
     * Handle the Membership "restored" event.
     */
    public function restored(Membership $membership): void
    {
        //
    }

    /**
     * Handle the Membership "force deleted" event.
     */
    public function forceDeleted(Membership $membership): void
    {
        //
    }
    private function notifyMembershipMembers(Membership $membership, Meeting $meeting, Board $board)
    {
        $user = User::find($membership->user_id);
        $isNew = true;
        $user->notify(new MeetingNewMembershipNotification($board, $meeting, $user, $isNew));
    }
}