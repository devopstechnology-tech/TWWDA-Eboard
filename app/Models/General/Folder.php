<?php

declare(strict_types=1);

namespace App\Models\General;

use App\Traits\Uuids;
use App\Models\BaseModel;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Folder extends BaseModel implements HasMedia
{
    use Uuids;
    use InteractsWithMedia;
    use SoftDeletes; // Enables soft deleting

    use HasFactory;
    protected $fillable = [
        'parent_id',
        'folderable_id',
        'folderable_type',
        'name',
        'type',
        'file_path',
    ];

    protected static function booted()
    {
        static::deleting(function ($folder) {
            // Move associated files to the 'Deleted' directory
            foreach ($folder->media as $media) {
                $newPath = "Deleted/Folder/{$folder->id}/" . $media->file_name;
                Storage::move($media->getPath(), $newPath);
                $media->update(['directory' => $newPath]);  // Update path in db if necessary
            }
        });

        static::restoring(function ($folder) {
            // Move files back to the active directory
            foreach ($folder->media as $media) {
                $activePath = "folders/{$folder->id}/" . $media->file_name;
                Storage::move($media->directory, $activePath);
                $media->update(['directory' => $activePath]);  // Update path in db if necessary
            }
        });
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file')
             ->singleFile()
             ->useDisk('secure');
    }
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }
    public function folderable()
    {
        return $this->morphTo();
    }
    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }
}
