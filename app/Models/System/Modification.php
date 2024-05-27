<?php

declare(strict_types=1);

namespace App\Models\System;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Modification extends BaseModel
{
    use Uuids;
    protected static array $having = [
        'modifications.modifiable_type',
        'modifications.modifications',
        'modifications.active',
    ];
    protected static array $filterable = [
        'modifiable_type' => 'modifications.modifiable_type',
        'modifications' => 'modifications.modifications',
        'active' => 'modifications.active',
    ];
    protected static array $searchable = [
        'modifications.modifiable_type',
        'modifications.modifications',
        'modifications.modifications.*',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'modifications' => 'json',
    ];
    protected $with = ['modifiable', 'modifier'];

    public static function boot(): void
    {
        parent::boot();
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('active', true);
        });
    }

    /**
     * Get models that the modification belongs to.
     */
    public function modifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get models that the ignited this modification.
     */
    public function modifier(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the number of approvals reamaining for the changes
     * to be approved and approval will close.
     */
    public function getApproversRemainingAttribute(): int
    {
        return $this->approvers_required - $this->approvals()->count();
    }

    /**
     * Return Approval relations via direct relation.
     */
    public function approvals(): HasMany
    {
        return $this->hasMany(config('approval.models.approval', Approval::class));
    }

    /**
     * Get the number of disapprovals reamaining for the changes
     * to be disapproved and approval will close.
     */
    public function getDisapproversRemainingAttribute(): int
    {
        return $this->disapprovers_required - $this->disapprovals()->count();
    }

    /**
     * Return Disapproval relations via direct relation.
     */
    public function disapprovals(): HasMany
    {
        return $this->hasMany(config('approval.models.disapproval', Disapproval::class));
    }

    /**
     * Convenience alias of ApproversRemaining attribute.
     */
    public function getApprovalsRemainingAttribute(): int
    {
        return $this->approversRemaining;
    }

    /**
     * Convenience alias of Disapprovers Remaining attribute.
     */
    public function getDisapprovalsRemainingAttribute(): int
    {
        return $this->disapproversRemaining;
    }

    /**
     * Force apply changes to modifiable.
     */
    public function forceApprovalUpdate(): void
    {
        $this->modifiable->applyModificationChanges($this, true);
    }

    /**
     * Scope to only include active modifications.
     */
    public function scopeActiveOnly(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Scope to only include inactive modifications.
     */
    public function scopeInactiveOnly(Builder $query): Builder
    {
        return $query->where('active', false);
    }

    /**
     * Scope to only retrieve changed models.
     */
    public function scopeChanges(Builder $query): Builder
    {
        return $query->where('is_update', true);
    }

    /**
     * Scope to only retrieve created models.
     */
    public function scopeCreations(Builder $query): Builder
    {
        return $query->where('is_update', false);
    }
}
