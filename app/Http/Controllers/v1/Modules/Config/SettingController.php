<?php

namespace App\Http\Controllers\v1\Modules\Config;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Config\Setting;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingRequest;
use App\Repository\Contracts\SettingInterface;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingInterface $settingRepository
    ) {
    }

    public function get(): JsonResponse
    {
        // $this->authorize('view', [Setting::class, $setting->id]);
        $setting = $this->settingRepository->getSetting();

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $setting, Setting::class);
    }
    public function getmailtypes(): JsonResponse
    {
        // $this->authorize('view', [Setting::class, $setting->id]);
        $setting = $this->settingRepository->getMailTypes();

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $setting, Setting::class);
    }
    public function update(UpdateSettingRequest $request, Setting $setting): JsonResponse
    {
        // dd($request, $setting);
        // $this->authorize('update', [Setting::class, $setting->id]);
        $setting = $this->settingRepository->update($setting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), $setting);
    }
}
