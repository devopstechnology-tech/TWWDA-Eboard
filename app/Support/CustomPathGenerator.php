<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\General\Folder;
use App\Models\Module\Board\Board;
use App\Models\Module\Committe\Committee;
use App\Models\Module\Meeting\Meeting;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    //     public function getPath(Media $media): string
    // {
    //         // If it is, generate the path using getPathForModel and concatenate the media ID
    //         return $this->getPathForModel($media->model) . "{$media->id}/";
    // }
    public function getPath(Media $media): string
    {
        // Eager load the 'model' relationship
        $media = Media::with('model')->findOrFail($media->id);

        // Use the eager loaded relationship to generate the path
        return $this->getPathForModel($media->model) . "{$media->id}/";
    }

    protected function getPathForModel($model): string
    {
        // If the model is a Folder and it's soft-deleted, return a path for deleted folders
        if ($model instanceof Folder && $model->trashed()) {
            return "Deleted/{$model->id}/";
        }

        // // If the model is a Folder, return a path based on its folderable relationship
        // if ($model instanceof Folder) {
        //     // Determine the parent path based on the folderable model
        //     $parentPath = $this->baseDirectory($model->folderable);
        //     // Concatenate the parent path, folderable ID, and folder ID to form the path
        //     return "{$parentPath}{$model->folderable->id}/{$model->id}/";
        // }

        // If the model is of another type, return a base directory path with the model ID
        // return $this->baseDirectory($model) . (property_exists($model, 'id') ? "{$model->id}/" : '');
        return (property_exists($model, 'id') ? "{$model->id}/" : '');
    }

    protected function baseDirectory($model): string
    {
        switch (get_class($model)) {
            case Board::class:
                return 'Board/';
            case Committee::class:
                return 'Committee/';
            case Meeting::class:
                return 'Meeting/';
            case Folder::class:
                return 'Folder/';
            default:
                return 'Archive/';  // Default or for deleted items
        }
    }
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive_images/';
    }
}
