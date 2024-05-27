<?php

declare(strict_types=1);

namespace App\Models\General;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use Uuids;
    use HasFactory;
    // protected $fillable = [
    //     'uuid',
    //     'collection_name',
    //     'name',
    //     'file_name',
    //     'mime_type',
    //     'disk',
    //     'conversions_disk',
    //     'size',
    //     'manipulations',
    //     'custom_properties',
    //     'generated_conversions',
    //     'responsive_images',
    //     'order_column',
    // ];
}
