<?php

declare(strict_types=1);

namespace App\Repository;

use App\Enums\TypeEnum;
use App\Http\Resources\FolderResource;
use App\Models\General\Folder;
use App\Models\Module\Board\Board;
use App\Models\Module\Committe\Committee;
use App\Models\Module\Meeting\Meeting;
use App\Repository\Contracts\FolderInterface;
use Illuminate\Http\UploadedFile;
use stdClass;

class FolderRepository extends BaseRepository implements FolderInterface
{
    // Implement the methods

    public function relationships()
    {
        return [
            // 'registerMediaCollections',
            'media',
            'folderable',
            'children.media',
            'children.folderable',
            'children.children.media',
            'children.children.folderable',
            'children.children.children.media',
            'children.children.children.folderable',
            'children.children.children.children.media',
            'children.children.children.children.folderable',
            'children.children.children.children.children.media',
            'children.children.children.children.children.folderable',
            'children.children.children.children.children.children.media',
            'children.children.children.children.children.children.folderable',
            'children.children.children.children.children.children.children.media',
            'children.children.children.children.children.children.children.folderable',
            'children.children.children.children.children.children.children.children.media',
            'children.children.children.children.children.children.children.children.folderable',
        ];
    }
    public function getAll()
    {
        // $board = Board::find(1); // Assuming a board exists with ID 1
        // $folder = new Folder();
        // $folder->name = 'Example Folder';
        // $folder->type = 'pdf';
        // $folder->folderable()->associate($board);
        // $folder->save();

        // $file = UploadedFile::fake()->create('folder.pdf', 1000, 'application/pdf');
        // $folder->addMedia($file)->toMediaCollection('folders');

        // $media = $folder->media->first();
        // echo $media->getPath(); // Output the path to see where it's being stored

        $filters = [
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Folder::class, FolderResource::class, $filters);
    }

    // board folders
    public function getBoardFolders($board)
    {
        $filters = [
            'folderable_id'   => $board,
            'folderable_type' => Board::class,
            'with'            => $this->relationships(),
            'orderBy'         => ['field' => 'id', 'direction' => 'asc']
        ];
        return $this->indexResource(Folder::class, FolderResource::class, $filters);
    }

    public function createBoardFolder($board, array $payload): Folder
    {
        $parentfolder = $this->getParentFolder($payload['parent_id']);
        $folder                    = new Folder();
        $folder->parent_id         = $parentfolder->id;
        $folder->folderable_id     = $parentfolder->id;
        $folder->folderable_type   = Folder::class;
        $folder->name              = $payload['name'];
        $folder->type              = $payload['type'];
        $folder->save();
        return $folder;
    }
    public function updateBoardFolder($board, $oldfolder, array $payload): Folder
    {
        $folder = Folder::find($payload['folder_id']);
        $folder->name              = $payload['name'];
        $folder->save();
        return $folder;
    }
    public function deleteBoardFolders($board)
    {
        $folders = Folder::where('folderable_id', $board->id)
            ->where('folderable_type', Board::class)
            ->get();

        foreach ($folders as $folder) {
            $this->deleteFolderRecursively($folder);
        }
    }

    private function deleteFolderRecursively($folder)
    {
        // Recursively delete child folders
        // Recursively delete child folders
        foreach ($folder->children as $child) {
            $this->deleteFolderRecursively($child);
        }

        // Handle deletion based on folder type
        if ($folder->type === 'file') {
            // Retrieve or create the 'Board Archives' folder
            $archiveFolder = $this->archiveFolder($folder);

            // Move all media items to the archive folder
            $mediaItems = $folder->getMedia();
            foreach ($mediaItems as $mediaItem) {
                $mediaItem->move($archiveFolder, 'file');
            }

            // Optionally, mark the original folder as archived or update status
            // $folder->name = $folder->name . " (Archived)";
            // $folder->save();
        } else {
            // Delete the folder itself after all children have been deleted
            $folder->delete();
        }
    }
    private function archiveFolder($folder)
    {
        // Assuming folderable_id refers to the parent entity (like Board)
        // and that 'Board Archives' is directly under this entity
        $archiveFolder = Folder::firstOrCreate(
            [
                'folderable_id'   => $folder->folderable_id,
                'folderable_type' => $folder->folderable_type,
                'name'            => 'Board Archives'
            ],
            [
                'type'            => 'file' // Make sure the type and other necessary attributes are set
            ]
        );

        return $archiveFolder;
    }

    public function forcedeleteBoardFolder($board)
    {
        $folders = Folder::where('folderable_id', $board->id)
            ->where('folderable_type', Board::class)
            ->get();

        foreach ($folders as $folder) {
            $this->forceDeleteFolderRecursively($folder);
        }
    }
    private function forceDeleteFolderRecursively($folder)
    {
        // Recursively delete all child folders first
        foreach ($folder->children as $child) {
            $this->forceDeleteFolderRecursively($child);
        }

        // Conditionally force delete all associated media files
        // Only if the folder type is NOT 'file'
        if ($folder->type === 'file') {
            $folder->media()->each(function ($media) {
                $media->forceDelete(); // Force delete media
            });
        }

        // Finally, force delete the folder itself
        // This happens regardless of the type
        $folder->forceDelete();
    }

    public function createBoardFileFolder($board, array $payload): Folder
    {
        // dd($payload);
        $parentfolder = $this->getParentFolder($payload['parent_id']);

        // for files,   parent must crete file folder (virtual)
        // so that in any case we create a file, it must pck the
        //parent that has file naem if not crerate file name then
        //add files, so in vue its iterated underchild file
        $folder                    = new Folder();
        $folder->parent_id         = $parentfolder->id;
        $folder->folderable_id   = $parentfolder->id;
        $folder->folderable_type = Folder::class;
        $folder->name              = $payload['name'];
        $folder->type              = $payload['type'];
        $folder->save();

        if (isset($payload['fileupload']) && $payload['fileupload'] instanceof UploadedFile) {
            $media = $folder->addMediaFromRequest('fileupload')
                ->toMediaCollection('file');
        }
        return $folder;
    }
    public function updateBoardFileFolder($board, $oldfolder, array $payload): Folder
    {
        $folder = Folder::find($payload['folder_id']);
        $folder->name              = $payload['name'];
        $folder->type              = $payload['type'];
        $folder->save();
        if (isset($payload['fileupload']) && $payload['fileupload'] instanceof UploadedFile) {
            $media = $folder->addMediaFromRequest('fileupload')
                ->toMediaCollection('file');
        } elseif ($folder->getFirstMedia('file')) {
            $media = $folder->getFirstMedia('file');
            $media->file_name = $payload['name'];
            $media->save();
        }
        return $folder;
    }

    public function getFile($folder, $file)
    {
        //    am here
        // dd($meeting, $folder, $file);
        $folder = Folder::find($folder);
        $media  = $folder->media->where('uuid', $file)->first();
        $fileRawContent = $media->getPath();
        $fileContent = file_get_contents($fileRawContent);
        // Encode the content to base64
        $base64File = base64_encode($fileContent);
        // Prepare the file metadata
        $fileData = [
            'fileName' => basename($fileRawContent),
            'fileSize' => filesize($fileRawContent),
            'fileType' => 'application/pdf',
            'file' => $base64File,
            'folderId' => $folder->id,
            'mediaId' => $media->uuid,
        ];
        return $fileData;
    }
    //updating from board or meetin file view
    public function updateFile($folder, $media, array $payload)
    {
        $folder = Folder::find($payload['folder_id']);
        $folder->name              = $payload['name'];
        $folder->type              = $payload['type'];

        $media = $folder->addMediaFromRequest('fileupload')
            ->toMediaCollection('file');
        $folder->save();
        if ($folder->save()) {
            $updatedfolder = Folder::with('media')->find($payload['folder_id']);
            $newmedia = $updatedfolder->media->first();
        }
        return $this->getFile($updatedfolder->id, $newmedia->uuid);
    }
    public function getMeetingFolders($meeting)
    {
        $filters = [
            'folderable_id'   => $meeting,
            'folderable_type' => Meeting::class,
            'with'              => $this->relationships(),
            // 'with'              => array_merge($this->relationships(), $this->includeChildren()),
            'orderBy'           => ['field' => 'id', 'direction' => 'asc']
        ];
        // dd($filters);
        return $this->indexResource(Folder::class, FolderResource::class, $filters);
    }
    public function createMeetingFolder(Meeting|string $meeting, Board|string $board, array $payload): Folder
    {
        $parentfolder = $this->getParentFolder($payload['parent_id']);
        $folder                    = new Folder();
        $folder->parent_id         = $parentfolder->id;
        $folder->folderable_id   = $parentfolder->id;
        $folder->folderable_type = Folder::class;
        $folder->name              = $payload['name'];
        $folder->type              = $payload['type'];
        $folder->save();
        return $folder;
    }
    public function updateMeetingFolder(Meeting|string $meeting, Board|string $board, array $payload): Folder
    {
        $parentfolder = $this->getParentFolder($payload['parent_id']);
        $folder = Folder::find($payload['folder_id']);
        // $folder->parent_id         = $parentfolder->id;
        // $folder->folderable_id   = $parentfolder->id;
        $folder->folderable_type = Folder::class;
        $folder->name              = $payload['name'];
        $folder->type              = $payload['type'];
        $folder->save();
        return $folder;
    }
    public function createMeetingFileFolder(Meeting|string $meeting, Board|string $board, array $payload): Folder
    {
        // dd($payload);
        $parentfolder = $this->getParentFolder($payload['parent_id']);

        // for files,   parent must crete file folder (virtual)
        // so that in any case we create a file, it must pck the
        //parent that has file naem if not crerate file name then
        //add files, so in vue its iterated underchild file
        $folder                    = new Folder();
        $folder->parent_id         = $parentfolder->id;
        $folder->folderable_id   = $parentfolder->id;
        $folder->folderable_type = Folder::class;
        $folder->name              = $payload['name'];
        $folder->type              = $payload['type'];
        $folder->save();

        if (isset($payload['fileupload']) && $payload['fileupload'] instanceof UploadedFile) {
            $media = $folder->addMediaFromRequest('fileupload')
                ->toMediaCollection('file');
        }
        return $folder;
    }
    public function updateMeetingFileFolder(Meeting|string $meeting, Board|string $board, array $payload): Folder
    {
        $folder = Folder::find($payload['folder_id']);
        $folder->name              = $payload['name'];
        $folder->type              = $payload['type'];
        $folder->save();
        if (isset($payload['fileupload']) && $payload['fileupload'] instanceof UploadedFile) {
            $media = $folder->addMediaFromRequest('fileupload')
                ->toMediaCollection('file');
        } elseif ($folder->getFirstMedia('file')) {
            $media = $folder->getFirstMedia('file');
            $media->file_name = $payload['name'];
            $media->save();
        }
        return $folder;
    }


    public function deleteMeetingFolder($meeting)
    {
        $folders = Folder::where('folderable_id', $meeting->id)
            ->where('folderable_type', Meeting::class)
            ->get();

        foreach ($folders as $folder) {
            $this->deleteMeetingFolderRecursively($folder);
        }
    }

    private function deleteMeetingFolderRecursively($folder)
    {
        // Recursively delete child folders
        // Recursively delete child folders
        foreach ($folder->children as $child) {
            $this->deleteFolderRecursively($child);
        }

        // Handle deletion based on folder type
        if ($folder->type === 'file') {
            // Retrieve or create the 'Meeting Archives' folder
            $archiveFolder = $this->archiveMeetingFolder($folder);

            // Move all media items to the archive folder
            $mediaItems = $folder->getMedia();
            foreach ($mediaItems as $mediaItem) {
                $mediaItem->move($archiveFolder, 'file');
            }

            // Optionally, mark the original folder as archived or update status
            // $folder->name = $folder->name . " (Archived)";
            // $folder->save();
        } else {
            // Delete the folder itself after all children have been deleted
            $folder->delete();
        }
    }
    private function archiveMeetingFolder($folder)
    {
        // Assuming folderable_id refers to the parent entity (like Meeting)
        // and that 'Meeting Archive' is directly under this entity
        $archiveFolder = Folder::firstOrCreate(
            [
                'folderable_id'   => $folder->folderable_id,
                'folderable_type' => $folder->folderable_type,
                'name'            => 'Meeting Archive'
            ],
            [
                'type'            => 'file' // Make sure the type and other necessary attributes are set
            ]
        );

        return $archiveFolder;
    }

    public function forcedeleteMeetingFolder($meeting)
    {
        $folders = Folder::where('folderable_id', $meeting->id)
            ->where('folderable_type', Meeting::class)
            ->get();

        foreach ($folders as $folder) {
            $this->forceDeleteMeetingFolderRecursively($folder);
        }
    }
    private function forceDeleteMeetingFolderRecursively($folder)
    {
        // Recursively delete all child folders first
        foreach ($folder->children as $child) {
            $this->forceDeleteFolderRecursively($child);
        }

        // Conditionally force delete all associated media files
        // Only if the folder type is NOT 'file'
        if ($folder->type === 'file') {
            $folder->media()->each(function ($media) {
                $media->forceDelete(); // Force delete media
            });
        }

        // Finally, force delete the folder itself
        // This happens regardless of the type
        $folder->forceDelete();
    }



    public function replaceMedia(Folder $folder, UploadedFile $newFile)
    {
        return $folder;
    }

    protected function renameMediaFile($media, $newFileName)
    {
        $oldPath = $media->getPath();
        $newPath = dirname($oldPath) . '/' . $newFileName;

        if (file_exists($oldPath)) {
            rename($oldPath, $newPath);  // Rename the file on disk
            $media->file_name = $newFileName;  // Update the file name in the database
            $media->save();  // Save the changes to the database
        }
    }


    public function createBoardDefaultFolder(Board|string $board, array $DefaultfolderNames): void
    {
        foreach ($DefaultfolderNames as $defaultname) {
            $folder = new Folder();
            $folder->folderable_id   = $board->id;
            $folder->folderable_type = Board::class;
            $folder->name              = $defaultname;
            $folder->type              = TypeEnum::Folder->value;
            $folder->save();
        }
    }
    public function createCommitteeDefaultFolder(Committee|string $committee, array $DefaultfolderNames): void
    {
        foreach ($DefaultfolderNames as $defaultname) {
            $folder = new Folder();
            $folder->folderable_id   = $committee->id;
            $folder->folderable_type = Committee::class;
            $folder->name              = $defaultname;
            $folder->type              = TypeEnum::Folder->value;
            $folder->save();
        }
    }
    public function createMeetingInitialFolder(Meeting $meeting, stdClass $boardcommittee, array $DefaultfolderNames): void
    {
        // name folder as : 1st Meeeting - dodod;
        $parentfolder = $this->getParentFolderable($boardcommittee);
        $meetingCount = $boardcommittee->meetingCount;
        $newMeetingNumber = $meetingCount + 1;
        $folderName = "{$newMeetingNumber}th Meeting -" . $meeting->title;
        // Adjust suffix for correct grammatical number (e.g., 1st, 2nd, 3rd)
        $folderName = $this->formatMeetingName($newMeetingNumber);

        $folder                    = new Folder();
        $folder->parent_id         = $parentfolder->id;
        $folder->folderable_id      = $meeting->id;
        $folder->folderable_type    = Meeting::class;
        $folder->name              = $folderName;
        $folder->type              = TypeEnum::Folder->value;
        $folder->save();
        if ($folder->save()) {
            $this->createDefaultMeetingFolders($folder, $DefaultfolderNames);
        }
    }
    public function createDefaultMeetingFolders(Folder $parentfolder, array $DefaultfolderNames): void
    {
        foreach ($DefaultfolderNames as $defaultname) {
            $folder                    = new Folder();
            $folder->parent_id         = $parentfolder->id;
            $folder->folderable_id     = $parentfolder->id;
            $folder->folderable_type   = Folder::class;
            $folder->name              = $defaultname;
            $folder->type              = TypeEnum::Folder->value;
            $folder->save();
        }
    }
    public function getParentFolderable($boardcommittee): Folder
    {
        return Folder::where('folderable_id', $boardcommittee->id)
            ->where('folderable_type', $boardcommittee->class)
            ->where('name', 'Meeting Folders') //we will be saving folders here fo curetn board
            ->first();
    }
    public function getParentFolder($parent_id): Folder
    {
        $parentfolder = Folder::find($parent_id);
        return  $parentfolder;
    }
    public function createParentFileFolder($parent_id): Folder
    {
        //creates parent with name file to ceate files
        return Folder::where('name', $parent_id)->first();
    }
    private function formatMeetingName($number)
    {
        $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
        if (($number % 100) >= 11 && ($number % 100) <= 13) {
            $suffix = 'th';
        } else {
            $suffix = $ends[$number % 10];
        }

        return "{$number}{$suffix} Meeting";
    }
    // private function includeChildren($level = 1) {
    //     // Adjust level to control the depth of the recursion
    //     $with = ['children'];
    //     for ($i = 1; $i < $level; $i++) {
    //         $with = array_merge($with, ["children.$with[0]"]);
    //     }
    //     return $with;
    // }

    //     public function updateMeetingFileFolder(Meeting|string $meeting, Board|string $board, array $payload): Folder
    // {
    //     $parentfolder = $this->getParentFolder($payload['parent_id']);
    //     $folder = Folder::find($payload['folder_id']);
    //     if (!$folder) {
    //         throw new \Exception("Folder not found.");
    //     }

    //     $folder->name = $payload['name'];
    //     $folder->type = $payload['type'];
    //     $folder->save();

    //     // Check if a new file is uploaded.
    //     if (isset($payload['fileupload']) && $payload['fileupload'] instanceof UploadedFile) {
    //         $this->replaceMedia($folder, $payload['fileupload']);
    //     } else if ($folder->getFirstMedia('folders')) {
    //         // Rename the existing file if no new file is uploaded.
    //         $media = $folder->getFirstMedia('folders');
    //         $newFileName = $payload['name'] . '.' . $media->extension;
    //         $this->renameMediaFile($media, $newFileName);
    //     }

    //     // Check if the folder needs to be deleted based on some condition in payload
    //     if (isset($payload['delete']) && $payload['delete'] === true) {
    //         $folder->delete(); // Soft delete triggers moving files to "Deleted" directory
    //     }

    //     return $folder;
    // }

    // protected function replaceMedia(Folder $folder, UploadedFile $newFile)
    // {
    //     $media = $folder->getFirstMedia('folders');
    //     if ($media) {
    //         $media->delete(); // Delete the media instance, triggers media file deletion
    //     }
    //     $folder->addMedia($newFile)
    //              ->toMediaCollection('folders');
    // }

    // protected function renameMediaFile(Media $media, string $newFileName)
    // {
    //     $oldPath = $media->getPath();
    //     $newPath = dirname($oldPath) . '/' . $newFileName;

    //     if (file_exists($oldPath) && !file_exists($newPath)) {
    //         rename($oldPath, $newPath);
    //         $media->file_name = $newFileName;
    //         $media->save();
    //     }
    // }

}
