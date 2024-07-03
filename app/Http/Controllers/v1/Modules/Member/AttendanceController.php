<?php

namespace App\Http\Controllers\v1\Modules\Member;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Module\Meeting\Schedule;
use App\Models\Module\Member\Attendance;
use App\Http\Requests\CreateAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Http\Requests\UpdateSignatureFileRequest;
use App\Repository\Contracts\AttendanceInterface;
use App\Http\Requests\CreateRSVPAttendanceRequest;
use App\Http\Requests\UpdateRSVPAttendanceRequest;

class AttendanceController extends Controller
{
    //
    public function __construct(private readonly AttendanceInterface $attendanceRepository)
    {
    }
    public function index(): JsonResponse
    {
        $attendances = $this->attendanceRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $attendances, Attendance::class);
    }
    public function getsignaturefile($attendance, $media): JsonResponse
    {
        $file = $this->attendanceRepository->getSignatureFile($attendance, $media);
        $headers = array(
            'Content-Type: application/wasm',
        );

        return $this->response(Response::HTTP_OK, __('messages.file-fetched'), $file, null, $headers);
    }
    public function updatesignature(UpdateSignatureFileRequest $request, $attendance, $media): JsonResponse
    {
        $file = $this->attendanceRepository->updateSignatureFile($attendance, $media, $request->validated());
        $headers = array(
            'Content-Type: application/wasm',
        );
        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $file, null, $headers);
    }

    public function show($schedule): JsonResponse
    {
        $attendances = $this->attendanceRepository->getScheduleAttendances($schedule);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $attendances, Attendance::class);
    }

    public function store(CreateAttendanceRequest $request, Schedule $schedule): JsonResponse
    {
        $attendance = $this->attendanceRepository->creatersvp($schedule, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $attendance, Attendance::class);
    }
    public function update(UpdateAttendanceRequest $request, Attendance $attendance): JsonResponse
    {
        $attendance = $this->attendanceRepository->update($attendance, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $attendance, Attendance::class);
    }
    public function reminder(UpdateAttendanceRequest $request, Attendance $attendance): JsonResponse
    {
        $attendance = $this->attendanceRepository->Reminder($attendance);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $attendance, Attendance::class);
    }
    public function creatersvp(CreateRSVPAttendanceRequest $request, Attendance $attendance): JsonResponse
    {
        $attendance = $this->attendanceRepository->createRSVP($attendance, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $attendance, Attendance::class);
    }
    public function updatersvp(UpdateRSVPAttendanceRequest $request, Attendance $attendance): JsonResponse
    {
        // dd($attendance);
        $attendance = $this->attendanceRepository->updateRSVP($attendance, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $attendance, Attendance::class);
    }
    public function signattendance(UpdateAttendanceRequest $request, Attendance $attendance): JsonResponse
    {
        $attendance = $this->attendanceRepository->SignAttendance($attendance, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $attendance, Attendance::class);
    }
    public function destroy(Attendance $attendance): JsonResponse
    {
        $attendance = $this->attendanceRepository->destroyScheduleAttendance($attendance);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $attendance, Attendance::class);
    }
}