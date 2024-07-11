<?php

declare(strict_types=1);

namespace App\Repository;

use stdClass;
use App\Models\User;
use App\Enums\PositionEnum;
use Illuminate\Http\UploadedFile;
use App\Models\Module\Board\Board;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BoardResource;
use App\Models\Module\Member\Position;
use App\Repository\Actions\ImageAction;
use App\Repository\Contracts\BoardInterface;
use App\Repository\Contracts\FolderInterface;
use App\Notifications\BoardUpdateNotification;
use App\Notifications\BoardNewMemberNotification;

class BoardRepository extends BaseRepository implements BoardInterface
{
    // Implement the methods
    public function __construct(private readonly FolderInterface $folderRepository)
    {
    }
    public function relationships()
    {
        return [
            'owner',
            'members',
            'members.user',
            'folders'
        ];
    }
    public function getAll()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical BoardResource for transformation
        $filters = [
            // 'owner_id' => Auth::user()->id,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Board::class, BoardResource::class, $filters);
    }
    public function getLatest()
    {
        // Adjust the implementation based on your actual logic
        // For example, using a hypothetical BoardResource for transformation
        $filters = [
            // 'owner_id' => Auth::user()->id,
            'limit' => 4,  // Limit to 4 records
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Board::class, BoardResource::class, $filters);
    }

    public function get(Board|string $board): Board
    {
        if (!($board instanceof Board)) {
            $board = Board::findOrFail($board);
        }

        return $board;
    }
    public function getMembers(Board|string $board): Board
    {
        if (!($board instanceof Board)) {
            $board = Board::findOrFail($board);
        }

        return $board;
    }    

    public function create(array $payload): Board
    {
        $user = Auth::user();
        $board = new Board($payload);
        $board->owner()->associate($user);

        $previousFileName = null;
        $iconName = $this->iconManage($payload, $board, $previousFileName);
        if ($iconName) {
            $coverName = $this->imageManage($payload, $board, $previousFileName);
            $board->icon = $iconName;
            $board->cover = $coverName;
        }

        $board->save();
        if ($board->wasRecentlyCreated) {
            $board->members()->create([
                'user_id' => $user->id,
                'position_id' => Position::where('name', 'Board Member')->first()->id,
                'board_id' =>  $board->id,
            ]);
            $DefaultfolderNames = [
                "Board Folders",
                "Board Archives",
                "Meeting Folders",
            ];
            $this->folderRepository->createBoardDefaultFolder($board, $DefaultfolderNames);
            // $user->notify(new BoardNewMemberNotification($user, $board));
        }
        return $board;
    }

    public function imageManage($payload, $board, $peviousfileName = null)
    {
        $cover = $payload['cover'] ?? null;
        if ($cover instanceof UploadedFile && $cover->isValid()) {
            $file = $payload['cover'];
            $folderLocation = '/images/cover/';
            // Create a new stdClass object
            $manupulation = new stdClass();
            // Set the properties
            $manupulation->targetHeight = 250;
            $manupulation->aspectRatio = 250 / 167;
            $manupulation->targetWidth = $manupulation->targetHeight * $manupulation->aspectRatio;

            $coverName = make(ImageAction::class)
                ->executeImage($file, $folderLocation, $manupulation, $peviousfileName);
        } else {

            $coverName = $peviousfileName;
        }
        return $coverName;
    }
    public function iconManage($payload, $board, $peviousfileName = null)
    {
        $icon = $payload['icon'] ?? null;
        if ($icon instanceof UploadedFile && $icon->isValid()) {
            $file = $payload['icon'];
            $folderLocation = '/images/icon/';
            // Create a new stdClass object
            $manupulation = new stdClass();
            // Set the properties
            $manupulation->targetHeight = 250;
            $manupulation->aspectRatio = 250 / 167;
            $manupulation->targetWidth = $manupulation->targetHeight * $manupulation->aspectRatio;

            $iconName = make(ImageAction::class)
                ->executeIcon($file, $folderLocation, $manupulation, $peviousfileName);
        } else {

            $iconName = $peviousfileName;
        }
        return $iconName;
    }

    public function update(Board|string $board, array $payload): Board
    {
        // dd('$payload', $board, $payload);
        if (!($board instanceof Board)) {
            $board = Board::findOrFail($board);
        }
        $previousIconFileName = $board->icon;
        $previousCoverFileName = $board->cover;
        $board->tempUserIds = $board->members()->pluck('user_id')->toArray();
        $board->update($payload);

        // Handle icon and cover updates if any changes are provided
        $iconName = $this->iconManage($payload, $board, $previousIconFileName);
        if ($iconName) {
            $board->icon = $iconName;
        }
        $coverName = $this->imageManage($payload, $board, $previousCoverFileName);
        if ($coverName) {
            $board->cover = $coverName;
        }
        $board->save();
        return $board;
    }


    public function updateMembers(Board|string $board, array $payload): Board
    {
        if (!($board instanceof Board)) {
            $board = Board::findOrFail($board);
        }

        $board->tempMemberUpdates = $payload['members'];
        // dd($board->tempMemberUpdates);
        $board->save();
        $board->touch();
        return $board;
    }
    public function updateMemberPosition(Board|string $board, array $payload): Board
    {
        if (!($board instanceof Board)) {
            $board = Board::findOrFail($board);
        }

        $board->tempMemberId = $payload['id'];
        $board->tempMemberPosition   = $payload['position_id'];
        // dd($board->tempMemberUpdates);
        $board->save();
        $board->touch();
        return $board;
    }

    public function delete(Board|string $board)
    {
        if (!($board instanceof Board)) {
            $board = Board::findOrFail($board);
        }
        $previousIconFileName = $board->icon;
        $previousCoverFileName = $board->cover;
        $iconfolderLocation = '/images/icon/';
        $coverfolderLocation = '/images/cover/';
        $deletedicon = make(ImageAction::class)->deleteImage($iconfolderLocation, $previousIconFileName);
        $deletecover = make(ImageAction::class)->deleteImage($coverfolderLocation, $previousCoverFileName);
        $this->folderRepository->deleteBoardFolders($board);
        return $board->delete();
    } // Implement the methods

}