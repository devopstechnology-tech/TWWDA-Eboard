<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use App\Models\General\Folder;
use App\Models\Module\Board\Board;
use App\Models\Module\Committe\Committee;
use App\Models\Module\Meeting\Meeting;
use stdClass;

interface FolderInterface
{
    // Define your methods here
    public function getAll();
    public function getFile($folder, $file);
    //be aupdated from board or meeting file view
    public function updateFile($folder, $file, array $payload);
    //board
    public function getBoardFolders($board);
    public function createBoardFolder($board, array $payload): Folder;
    public function updateBoardFolder($board, $folder, array $payload): Folder;
    public function deleteBoardFolders($board);
    public function forceDeleteBoardFolder($board);
    public function createBoardFileFolder($board, array $payload): Folder;
    public function updateBoardFileFolder($board, $folder, array $payload): Folder;

     //committee
     public function getCommitteeFolders($committee);
     public function createCommitteeFolder($committee, array $payload): Folder;
     public function updateCommitteeFolder($committee, $folder, array $payload): Folder;
     public function deleteCommitteeFolders($committee);
     public function forceDeleteCommitteeFolder($committee);
     public function createCommitteeFileFolder($committee, array $payload): Folder;
     public function updateCommitteeFileFolder($committee, $folder, array $payload): Folder;
 
    //meeting
    public function getMeetingFolders($meeting);
    public function createMeetingFolder(Meeting|string $meeting, array $payload): Folder;
    public function updateMeetingFolder(Meeting|string $meeting, array $payload): Folder;
    public function createMeetingFileFolder(Meeting|string $meeting, array $payload): Folder;
    public function updateMeetingFileFolder(Meeting|string $meeting, array $payload): Folder;
    public function deleteMeetingFolder($board);
    public function forcedeleteMeetingFolder($board);

    // default
    public function createBoardDefaultFolder(Board|string $board, array $DefaultfolderNames): void;
    public function createCommitteeDefaultFolder(Committee|string $committee, array $DefaultfolderNames): void;
    //first on eper meeting like 1st meeting
    public function createMeetingInitialFolder(Meeting $meeting, stdClass $boardcommittee, array $DefaultfolderNames): void;
}
