<?php

namespace App\Repository;

use App\Models\User;
use App\Enums\RSVPEnum;
use App\Enums\AttendanceEnum;
use Illuminate\Http\UploadedFile;
use App\Repository\BaseRepository;
use App\Models\Module\Meeting\Schedule;
use App\Models\Module\Member\Attendance;
use App\Models\Module\Member\Membership;
use App\Http\Resources\AttendanceResource;
use App\Repository\Contracts\AttendanceInterface;
use App\Notifications\AttendanceReminderNotification;

class AttendanceRepository extends BaseRepository implements AttendanceInterface
{
    // Implement the methods
    public function relationships()
    {
        return [
            'membership.user.profile',
            'membership.member',
            'membership.position',
            'media',
            'schedule.meeting',
        ];
    }
    public function getAll()
    {
        // membership
        // schedule
        $filters = [
            // 'owner_id' => Auth::user()->id,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Attendance::class, AttendanceResource::class, $filters);
    }
    public function getScheduleAttendances($schedule)
    {
        $filters = [
            'schedule_id' => $schedule,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Attendance::class, AttendanceResource::class, $filters);
    }
    public function getSignatureFile($attendance, $file)
    {
        $attendance = Attendance::with($this->relationships())->find($attendance);
        $media = $attendance->media->where('uuid', $file)->first();
        $fileRawContent = $media->getPath();
        $fileContent = file_get_contents($fileRawContent);
        $base64File = base64_encode($fileContent);
        $fileData = [
            'fileName' => basename($fileRawContent),
            'fileSize' => filesize($fileRawContent),
            'fileType' => 'application/pdf',
            'file' => $base64File,
            'attendance' => $attendance,
            'mediaId' => $media->uuid,
        ];
        return $fileData;
    }


    public function create(Schedule | string $schedule, Membership | string $membership)
    {
        $attendance = new Attendance();
        $attendance->schedule_id       = $schedule->id;
        $attendance->membership_id     = $membership->id;
        $attendance->rsvp_status       = RSVPEnum::Default->value;
        $attendance->attendance_status = AttendanceEnum::Default->value;
        $attendance->save();
        if ($attendance->save()) {
            $relativePath = 'secure/sign/blanksignatureform.pdf';
            $attendanceId = $attendance->id;
            $fileData = $attendance->getBlankPdf($relativePath, $attendanceId);
            $media = $attendance->addMediaFromBase64($fileData['file'])
                ->toMediaCollection('sign');
        }
        return $attendance;
    }


    public function update(Schedule | string $schedule, Membership | string $membership)
    {
        if (!($schedule instanceof Schedule)) {
            $schedule = Schedule::findOrFail($schedule);
        }
        $attendance = new Attendance();
        $attendance->schedule_id = $schedule->id;
        $attendance->membership_id = $membership->id;
        $attendance->rsvp_status = RSVPEnum::Default->value;
        $attendance->attendance_status = AttendanceEnum::Default->value;
        $attendance->save();

        if ($attendance->save()) {
            $relativePath = 'secure/sign/blanksignatureform.pdf';
            $attendanceId = $attendance->id;
            $fileData = $attendance->getBlankPdf($relativePath, $attendanceId);

            $attendance->addMediaFromBase64($fileData['file'])
                ->toMediaCollection('sign');
        }

        return $attendance;
    }

    public function Reminder(Attendance | string $attendance)
    {
        if (!($attendance instanceof Attendance)) {
            $attendance = Attendance::findOrFail($attendance);
        }
        $user_id = $attendance->membership->user_id;
        $user = User::find($user_id);
        $updateMessage = "Please sign the attendance list for the meeting '
                       {$attendance->schedule->meeting->title}'.";

        $user->notify(new AttendanceReminderNotification($user, $attendance, $updateMessage));
    }
    public function createRSVP(Attendance | string $attendance, array $payload)
    {
    }
    public function updateRSVP(Attendance | string $attendance, array $payload)
    {
        // dd($attendance);
        if (!($attendance instanceof Attendance)) {
            $attendance = Attendance::findOrFail($attendance);
        }
        $attendance->rsvp_status = $payload['rsvp_status'];
        $attendance->save();
        return $attendance;
    }
    public function updateSignatureFile(Attendance | string $attendance, $file, array $payload)
    {
        if (!($attendance instanceof Attendance)) {
            $attendance = Attendance::findOrFail($attendance);
        }
        $attendance->attendance_status = AttendanceEnum::Attended->value;
        // $attendance->location = $payload['location'];
        $attendance->save();

        $attendance->clearMediaCollection('sign');

        $attendance->addMediaFromRequest('signatureupload')
            ->toMediaCollection('sign');

        if ($attendance->save()) {
            $updatedattendance = Attendance::with('media')->find($attendance->id);
            $newmedia = $updatedattendance->media->first();
            return $this->getSignatureFile($updatedattendance->id, $newmedia->uuid);
        }
    }
    public function destroyAttendance($oldMembershipId)
    {
        $attendance = Attendance::where('membership_id', $oldMembershipId)->first();
        $attendance->clearMediaCollection('sign');
        $attendance->forceDelete();
    }
    public function destroyAttendances(array $oldMembershipIds)
    {
        // $attendances = Attendance::whereIn('membership_id', $oldMembershipIds)->get();

        // foreach ($attendances as $attendance) {
        //     $allmedia = $attendance->getMedia('sign');
        //     dd($allmedia);
        //     // Delete all associated media for each attendance
        //     $attendance->clearMediaCollection('sign');
        //     // Optionally, clear any other media collections associated with attendance
        // }

        // // Force delete the attendances after their media has been deleted
        // return Attendance::whereIn('membership_id', $oldMembershipIds)->forceDelete();
    }

    public function destroyScheduleAttendance(Attendance | string $attendance)
    {
    }
}