<?php

declare(strict_types=1);

namespace App\Models\Module\Member;

use App\Traits\Uuids;
use App\Enums\RSVPEnum;
use App\Enums\InviteEnum;
use App\Models\BaseModel;
use App\Enums\AttendanceEnum;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Meeting\Schedule;
use Illuminate\Support\Facades\Storage;
use App\Models\Module\Member\Membership;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Attendance extends BaseModel implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use Uuids;
    use InteractsWithMedia;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'location',
        'schedule_id',
        'membership_id',
        'invite_status',
        'rsvp_status',
        'attendance_status',
    ];
    protected $casts = [
        'invite_status' => InviteEnum::class,
        'rsvp_status' => RSVPEnum::class,
        'attendance_status' => AttendanceEnum::class,
    ];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('sign')
            ->singleFile() // Ensure this is set
            ->useDisk('secure');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function  getBlankPdf(string $relativePath, string $attendanceId)
    {
        if (!Storage::exists($relativePath)) {
            throw new \Exception("File does not exist at path: {$relativePath}");
        }

        $absolutePath = Storage::path($relativePath);
        $fileContent = Storage::get($relativePath);
        $base64File = base64_encode($fileContent);

        $attendance = $this->find($attendanceId);
        $membership = $attendance->membership;
        $user = $membership->user;

        $fileData = [
            'fileName' => basename($absolutePath),
            'fileSize' => Storage::size($relativePath),
            'fileType' => 'application/pdf',
            'file' => $base64File,
            'attendanceId' => $attendanceId,
            'mediaId' => $this->uuid,
            'fullName' => $user->full_name,
        ];

        return $fileData;
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id')
            ->with('position', 'user');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id')
                    ->with('meeting');
    }
}
