<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\ApprovalException;
use App\Models\System\Approval;
use App\Models\System\Disapproval;
use App\Models\System\Modification;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait ApprovesChanges
{
    /**
     * Approve a modification.
     */
    public function approve(Modification $modification, ?string $reason = null): bool
    {
        if ($this->authorizedToApprove($modification)) {

            // Prevent disapproving and approving
            if ($disapproval = $this->disapprovals()->where([
                'disapprover_id' => $this->{$this->primaryKey},
                'disapprover_type' => get_class(),
                'modification_id' => $modification->id,
            ])->first()) {
                $disapproval->delete();
            }

            // Prevent duplicates
            $approvalModel = config('approval.models.approval', Approval::class);
            $approvalModel::firstOrCreate([
                'approver_id' => $this->{$this->primaryKey},
                'approver_type' => get_class(),
                'modification_id' => $modification->id,
                'reason' => $reason,
            ]);

            $modification->fresh();
            if ($modification->approversRemaining == 0
                || $this->hasSuperAdminRole()) {
                if ($modification->modifiable_id === null) {
                    $polymorphicModel = new (Relation::getMorphedModel($modification->modifiable_type))();
                    $polymorphicModel->applyModificationChanges($modification, true);
                } else {
                    $modification->modifiable->applyModificationChanges($modification, true);
                }
            }

            return true;
        }
        throw new ApprovalException('Not authorized to make approval');
    }

    /**
     * Defines if this model is allowed to cast their approval
     * should be actioned for this model.
     */
    protected function authorizedToApprove(/* @scrutinizer ignore-unused */ Modification $modification): bool
    {
        return true;
    }

    /**
     * Return Disapproval relations via moprhMany.
     */
    public function disapprovals(): MorphMany
    {
        return $this->/* @scrutinizer ignore-call */ morphMany(Disapproval::class, 'disapprover');
    }

    /**
     * Disapprove a modification.
     */
    public function disapprove(Modification $modification, ?string $reason = null): bool
    {
        if ($this->authorizedToDisapprove($modification)) {

            // Prevent approving and disapproving
            if ($approval = $this->approvals()->where([
                'approver_id' => $this->{$this->primaryKey},
                'approver_type' => get_class(),
                'modification_id' => $modification->id,
            ])->first()) {
                $approval->delete();
            }

            // Prevent duplicates
            $disapprovalModel = config('approval.models.disapproval', Disapproval::class);
            $disapprovalModel::firstOrCreate([
                'disapprover_id' => $this->{$this->primaryKey},
                'disapprover_type' => get_class(),
                'modification_id' => $modification->id,
                'reason' => $reason,
            ]);

            $modification->fresh();

            if ($modification->disapproversRemaining == 0) {
                if ($modification->modifiable_id === null) {
                    $polymorphicModel = new (Relation::getMorphedModel($modification->modifiable_type))();
                    $polymorphicModel->applyModificationChanges($modification, false);
                } else {
                    $modification->modifiable->applyModificationChanges($modification, false);
                }
            }

            return true;
        }
        throw new ApprovalException('Not authorized to make disapproval');
    }

    /**
     * Defines if this model is allowed to cast their disapproval
     * should be actioned for this model.
     */
    protected function authorizedToDisapprove(/* @scrutinizer ignore-unused */ Modification $modification): bool
    {
        return true;
    }

    /**
     * Return Approval relations via moprhMany.
     */
    public function approvals(): MorphMany
    {
        return $this->/* @scrutinizer ignore-call */ morphMany(Approval::class, 'approver');
    }
}
