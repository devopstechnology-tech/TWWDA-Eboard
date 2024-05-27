<?php

namespace App\Repository\Contracts;

use App\Models\Config\Setting;
use App\Http\Resources\SettingResource;

interface SettingInterface
{
    // Define your methods here
    public function getSetting(): SettingResource;
    public function getMailTypes(): SettingResource;
    public function update(Setting|string $setting, array $paylload): SettingResource;
}