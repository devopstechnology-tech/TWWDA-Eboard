<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\System\Modification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RequiresApproval
{
    /**
     * Boolean to mark bypass approval.
     */
    protected static bool $byPassApproval = false;
    /**
     * Number of approvers this model requires in order
     * to mark the modifications as accepted.
     */
    protected int $approversRequired = 1;

    /**
     * Number of disapprovers this model requires in order
     * to mark the modifications as rejected.
     */
    protected int $disapproversRequired = 1;
    /**
     * Boolean to mark whether this model should be updated
     * automatically upon receiving the required number of approvals.
     */
    protected bool $updateWhenApproved = true;
    /**
     * Boolean to mark whether the approval model should be deleted
     * automatically when the approval is disapproved with the required number
     * of disapprovals.
     */
    protected bool $deleteWhenDisapproved = false;
    /**
     * Boolean to mark whether the approval model should be deleted
     * automatically when the approval is approved with the required number
     * of approvals.
     */
    protected bool $deleteWhenApproved = true;
    /**
     * Boolean to mark whether the approval model should be saved
     * forcefully.
     */
    private bool $forcedApprovalUpdate = false;

    /**
     * Boot the RequiresApproval trait. Listen for events and perform logic.
     */
    public static function bootRequiresApproval(): void
    {

        static::saving(function ($item) {
            // if ($item->isApprovalByPassed()) {
            //     $item->setForcedApprovalUpdate(false);

            //     return true;
            // }
            // if (!$item->isForcedApprovalUpdate() && $item->requiresApprovalWhen($item->getDirty()) === true) {
            //     return self::captureSave($item);
            // }
            // $item->setForcedApprovalUpdate(false);

            return true;
        });
        static::deleting(function ($item) {
            if ($item->isApprovalByPassed()) {
                $item->setForcedApprovalUpdate(false);

                return true;
            }
            if (!$item->isForcedApprovalUpdate() && $item->requiresApprovalWhen($item->getAttributes()) === true) {
                return self::captureSave($item, 'deleted');
            }
            $item->setForcedApprovalUpdate(false);

            return true;
        });
    }

    /**
     * Check is the approval can be bypassed.
     */
    public function isApprovalByPassed(): bool
    {
        return self::$byPassApproval;
    }

    /**
     * Returns true if the model is being force updated.
     */
    public function isForcedApprovalUpdate(): bool
    {
        return $this->forcedApprovalUpdate;
    }

    /**
     * Setter for forcedApprovalUpdate.
     */
    public function setForcedApprovalUpdate(bool $forced = true): bool
    {
        return $this->forcedApprovalUpdate = $forced;
    }

    /**
     * Function that defines the rule of when an approval process
     * should be actioned for this model.
     */
    protected function requiresApprovalWhen(array $modifications): bool
    {
        if (app()->environment() === 'testing') {
            return false;
        }

        return true;
    }

    public static function captureSave($item, $action = 'updated'): bool
    {

        $diff = $action === 'deleted' ? $item : collect($item->getDirty())
            ->transform(function ($change, $key) use ($item) {
                return [
                    'original' => $item->getOriginal($key),
                    'modified' => $item->$key,
                ];
            })->all();

        $hasModificationPending = $item->modifications()
            ->activeOnly()
            ->where('md5', md5(json_encode($diff)))
            ->first();

        $modifier = $item->modifier();

        $modificationModel = config('approval.models.modification', Modification::class);

        $modification = $hasModificationPending ?? new $modificationModel();
        $modification->active = true;
        $modification->action = $action;
        $modification->modifications = $diff;
        $modification->approvers_required = $item->approversRequired;
        $modification->disapprovers_required = $item->disapproversRequired;
        $modification->md5 = md5(json_encode($diff));

        if ($modifier && ($modifierClass = get_class($modifier))) {
            $modifierInstance = new $modifierClass();

            $modification->modifier_id = $modifier->{$modifierInstance->getKeyName()};
            $modification->modifier_type = (new $modifierClass())->getMorphClass();
        }

        if (is_null($item->{$item->getKeyName()})) {
            $modification->is_update = false;
            $modification->action = 'created';
        }

        $modification->save();

        if (!$hasModificationPending) {
            $item->modifications()->save($modification);
        }

        return false;
    }

    /**
     * Return Modification relations via moprhMany.
     */
    public function modifications(): MorphMany
    {
        return $this->morphMany(config('approval.models.modification', Modification::class), 'modifiable');
    }

    /**
     * Returns the model that should be used as the modifier of the modified model.
     */
    protected function modifier(): ?Authenticatable
    {
        return auth()->user();
    }

    /**
     * Return collection of creations for the current model
     */
    public static function creations(): Collection
    {
        $modificationClass = config('approval.models.modification', Modification::class);

        return $modificationClass::whereModifiableType(static::class)->whereIsUpdate(false)->get();
    }

    /**
     * sets the bypass variable to true
     */
    public static function withoutApproval(): static
    {
        self::$byPassApproval = true;

        return new static();
    }

    /**
     * Apply modification to model.
     */
    public function applyModificationChanges(Modification $modification, bool $approved): void
    {
        if ($approved && $this->updateWhenApproved) {
            $this->setForcedApprovalUpdate(true);
            if ($modification['action'] == 'deleted') {
                $this->delete();
                $modification->delete();

                return;
            }

            foreach ($modification->modifications as $key => $mod) {
                $this->{$key} = $mod['modified'];
            }
            if ($modification['action'] == 'updated') {
                $this->save();
            }
            if ($modification['action'] == 'created') {
                $this->saveWithoutEvents();
            }
            $modification->modifiable_id = $this->id;
            $modification->save();

            if ($this->deleteWhenApproved) {
                $modification->delete();
            } else {
                $modification->active = false;
                $modification->save();
            }
        } elseif ($approved === false) {
            if ($this->deleteWhenDisapproved) {
                $modification->delete();
            } else {
                $modification->active = false;
                $modification->save();
            }
        }
    }
}
