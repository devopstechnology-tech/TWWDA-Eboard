<?php

declare(strict_types=1);

namespace App\Repository\Actions;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageAction
{
    public function executeImage($file, $folderLocation, $manupulation, $peviousfileName = null)
    {
        $extension = $file->getClientOriginalExtension(); // Get the original extension
        $fileName = time() . ".{$extension}"; // Create the new filename
        $image = $this->saveImage($file, $fileName, $folderLocation, $peviousfileName, $manupulation);

        return $fileName;
    }
    public function executeIcon($file, $folderLocation, $manupulation, $peviousfileName = null)
    {
        $extension = $file->getClientOriginalExtension(); // Get the original extension
        $fileName = time() . ".{$extension}"; // Create the new filename
        $image = $this->saveImage($file, $fileName, $folderLocation, $peviousfileName, $manupulation);

        return $fileName;
    }
    public function executeAvatar($file, $folderLocation, $manupulation, $peviousfileName = null)
    {
        $extension = $file->getClientOriginalExtension(); // Get the original extension
        $fileName = time() . ".{$extension}"; // Create the new filename
        $image = $this->saveImage($file, $fileName, $folderLocation, $peviousfileName, $manupulation);

        return $fileName;
    }
    public function executeLogo($file, $folderLocation, $manupulation, $peviousfileName = null)
    {
        $extension = $file->getClientOriginalExtension(); // Get the original extension
        $fileName = time() . ".{$extension}"; // Create the new filename
        $image = $this->saveImage($file, $fileName, $folderLocation, $peviousfileName, $manupulation);

        return $fileName;
    }
    public function executeTextlogo($file, $folderLocation, $manupulation, $peviousfileName = null)
    {
        $extension = $file->getClientOriginalExtension(); // Get the original extension
        $fileName = time() . ".{$extension}"; // Create the new filename
        $image = $this->saveImage($file, $fileName, $folderLocation, $peviousfileName, $manupulation);

        return $fileName;
    }
    public function executeIsologo($file, $folderLocation, $manupulation, $peviousfileName = null)
    {
        $extension = $file->getClientOriginalExtension(); // Get the original extension
        $fileName = time() . ".{$extension}"; // Create the new filename
        $image = $this->saveImage($file, $fileName, $folderLocation, $peviousfileName, $manupulation);

        return $fileName;
    }


    public function saveImage($file, $fileName, $folderLocation, $previousFileName, $manipulation)
    {
        $path = public_path() . $folderLocation;
        if ($previousFileName !== null) {
            $oldImage = $path . '/' . $previousFileName;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
        }

        if (!file_exists($path)) {
            mkdir($path, 0777, true); // Adjust permissions as necessary
            error_log('Directory created');
        }

        $image = Image::make($file);
        $targetHeight = $manipulation->targetHeight;
        $aspectRatio = $manipulation->aspectRatio;
        $targetWidth = $targetHeight * $aspectRatio;

        $image->resize($targetWidth, $targetHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize(); // Optionally prevent upsizing
        });

        try {
            $image->save($path . '/' . $fileName);
        } catch (\Exception $e) {
            error_log('Error saving image: ' . $e->getMessage());
            throw new \Exception('Error saving image: ' . $e->getMessage());
        }

        return $image;
    }
    public function deleteImage($folderLocation, $previousFileName)
    {
        $path = public_path() . $folderLocation;
        if ($previousFileName !== null) {
            $oldImage = $path . '/' . $previousFileName;
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
        }

        return true;
    }
}