<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Config\ApprovalConfig;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ApprovalConfigurable
{
    protected int $approversRequired = 1;
    protected int $disapproversRequired = 1;
    protected bool $updateWhenApproved = true;
    protected bool $deleteWhenDisapproved = false;
    protected bool $deleteWhenApproved = true;
    protected string $minAdminLevel = 'default';

    public function initializeApprovalConfigurable(): void
    {
        if (app()->environment() !== 'testing') {
            $this->config();
        }
    }

    public function config(): void
    {
        //        return $this->morphOne(ApprovalConfig::class, 'configurable')->latestOfMany();
        try {
            $config = ApprovalConfig::where('configurable_type', get_class($this->getModel()))->first();
            if ($config) {
                $this->approversRequired = $config->approvers_required;
                $this->disapproversRequired = $config->disapprovers_required;
                $this->updateWhenApproved = (bool) $config->update_when_approved;
                $this->deleteWhenApproved = (bool) $config->delete_when_approved;
                $this->deleteWhenDisapproved = (bool) $config->delete_when_disapproved;
                $this->minAdminLevel = $config->min_admin_level;
            }
        } catch (\Exception $e) {

        }

    }

    public function approvalConfigurable(): MorphMany
    {
        return $this->morphMany(ApprovalConfig::class, 'configurable');
    }
}
