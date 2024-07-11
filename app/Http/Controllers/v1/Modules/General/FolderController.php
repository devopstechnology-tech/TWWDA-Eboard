<?php

declare(strict_types=1);

namespace App\Http\Controllers\v1\Modules\General;

use Illuminate\Http\Response;
use App\Models\General\Folder;
use Illuminate\Http\JsonResponse;
use App\Models\Module\Board\Board;
use App\Http\Controllers\Controller;
use App\Models\Module\Meeting\Meeting;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Requests\CreateFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use App\Repository\Contracts\FolderInterface;
use App\Http\Requests\CreateBoardFileFolderRequest;
use App\Http\Requests\UpdateBoardFileFolderRequest;
use App\Http\Requests\CreateMeetingFileFolderRequest;
use App\Http\Requests\UpdateMeetingFileFolderRequest;
use App\Http\Requests\CreateCommitteeFileFolderRequest;
use App\Http\Requests\UpdateCommitteeFileFolderRequest;

class FolderController extends Controller
{
    public function __construct(private readonly FolderInterface $folderRepository)
    {
    }
    public function index(): JsonResponse
    {
        $folders = $this->folderRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folders, Folder::class);
    }
    //file
    public function getfile($folder, $media): JsonResponse
    {
        $file = $this->folderRepository->getFile($folder, $media);
        $headers = array(
            'Content-Type: application/wasm',
        );

        return $this->response(Response::HTTP_OK, __('messages.file-fetched'), $file, null, $headers);
    }
    public function updatefile(UpdateFileRequest $request, $folder, $media): JsonResponse
    {
        $file = $this->folderRepository->updateFile($folder, $media, $request->validated());
        $headers = array(
            'Content-Type: application/wasm',
        );

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $file, null, $headers);
    }
    //board
    public function getboardfolders($board): JsonResponse
    {
        $folders = $this->folderRepository->getBoardFolders($board);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folders, Folder::class);
    }
    public function createboardfolder(CreateFolderRequest $request, $board): JsonResponse
    {
        $folder = $this->folderRepository->createBoardFolder($board, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }
    public function updateboardfolder(UpdateFolderRequest $request, $board, $folder): JsonResponse
    {
        $folder = $this->folderRepository->updateBoardFolder($board, $folder, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }
    public function createboardfilefolder(CreateBoardFileFolderRequest $request, $board): JsonResponse
    {
        $folder = $this->folderRepository->createBoardFileFolder($board, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }
    public function updateboardfilefolder(UpdateBoardFileFolderRequest $request, $board, $folder): JsonResponse
    {
        $folder = $this->folderRepository->updateBoardFileFolder($board, $folder, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }

    //committee
    public function getcommitteefolders($committee): JsonResponse
    {
        $folders = $this->folderRepository->getCommitteeFolders($committee);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folders, Folder::class);
    }
    public function createcommitteefolder(CreateFolderRequest $request, $committee): JsonResponse
    {
        $folder = $this->folderRepository->createCommitteeFolder($committee, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }
    public function updatecommitteefolder(UpdateFolderRequest $request, $committee, $folder): JsonResponse
    {
        $folder = $this->folderRepository->updateCommitteeFolder($committee, $folder, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }
    public function createcommitteefilefolder(CreateCommitteeFileFolderRequest $request, $committee): JsonResponse
    {
        $folder = $this->folderRepository->createCommitteeFileFolder($committee, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }
    public function updatecommitteefilefolder(UpdateCommitteeFileFolderRequest $request, $committee, $folder): JsonResponse
    {
        $folder = $this->folderRepository->updateCommitteeFileFolder($committee, $folder, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }




    //meeting

    public function getmeetingfolders($meeting): JsonResponse
    {
        $folders = $this->folderRepository->getMeetingFolders($meeting);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folders, Folder::class);
    }


    public function createmeetingfolder(CreateFolderRequest $request, Meeting $meeting): JsonResponse
    {
        $folder = $this->folderRepository->createMeetingFolder($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }
    public function updatemeetingfolder(UpdateFolderRequest $request, Meeting $meeting): JsonResponse
    {
        $folder = $this->folderRepository->updateMeetingFolder($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }
    public function createmeetingfilefolder(CreateMeetingFileFolderRequest $request, Meeting $meeting): JsonResponse
    {
        $folder = $this->folderRepository->createMeetingFileFolder($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }
    public function updatemeetingfilefolder(UpdateMeetingFileFolderRequest $request, Meeting $meeting): JsonResponse
    {
        $folder = $this->folderRepository->updateMeetingFileFolder($meeting, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $folder, Folder::class);
    }
}
