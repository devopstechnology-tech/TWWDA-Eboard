<?php

declare(strict_types=1);

namespace App\Repository;

use stdClass;
use App\Enums\StatusEnum;
use Illuminate\Http\UploadedFile;
use App\Models\Module\Board\Board;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Module\Member\Position;
use App\Repository\Actions\ImageAction;
use App\Http\Resources\CommitteeResource;
use App\Models\Module\Committe\Committee;
use App\Repository\Contracts\FolderInterface;
use App\Repository\Contracts\CommitteeInterface;
use App\Repository\Contracts\CommitteeMemberInterface;

class CommitteeRepository extends BaseRepository implements CommitteeInterface
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
           'meetings',
           'committeeable',
           'members',
        //    'folders',
       ];
   }
   public function getAll()
   {
       // Adjust the implementation based on your actual logic
       // For example, using a hypothetical CommitteeResource for transformation
       $filters = [
           // 'owner_id' => Auth::user()->id,
           'with' => $this->relationships(),
           'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
       ];
       return $this->indexResource(Committee::class, CommitteeResource::class, $filters);
   }
   public function getLatest()
   {
       // Adjust the implementation based on your actual logic
       // For example, using a hypothetical CommitteeResource for transformation
       $filters = [
           'limit' => 4,
           // 'owner_id' => Auth::user()->id,
           'with' => $this->relationships(),
           'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
       ];
       return $this->indexResource(Committee::class, CommitteeResource::class, $filters);
   }
   public function getBoardCommittee($board)
    {
        $filters = [
            'committeeable_id' => $board,
            // 'committeeable_type' => Board::class,
            'with' => $this->relationships(),
            'orderBy' => ['field' => 'created_at', 'direction' => 'asc']
        ];
        return $this->indexResource(Committee::class, CommitteeResource::class, $filters);
    }

   public function get(Committee|string $committee): Committee
   {
       if (!($committee instanceof Committee)) {
           $committee = Committee::findOrFail($committee);
       }

       return $committee;
   }
   public function getMembers(Committee|string $committee): Committee
   {
       if (!($committee instanceof Committee)) {
           $committee = Committee::findOrFail($committee);
       }

       return $committee;
   }
   public function fetchAuthMember(string $id)
   {
       $committee = Committee::findOrFail($id);
       $member = $committee->members()->where('user_id', Auth::user()->id)->first();
       return $member;
   }
   

   public function create(Board $board, array $payload): Committee
   {
    //'name',
    //'description',
    //'icon',
    //'cover',
    //'status',
    //'owner_id',
    //'committeeable_id',
    //'committeeable_type',
    if (!($board instanceof Board)) {
        $board = Board::findOrFail($board);
    }
       $user = Auth::user();
       $committee = new Committee();
       $committee->name        = $payload['name'];
       $committee->description = $payload['description'];
       $committee->status      = StatusEnum::Active->value;
       $committee->committeeable_id = $board->id;
       $committee->committeeable_type = 'board';
       $committee->owner()->associate($user);

       $previousFileName = null;
       $iconName = $this->iconManage($payload, $committee, $previousFileName);
       if ($iconName) {
           $coverName = $this->imageManage($payload, $committee, $previousFileName);
           $committee->icon = $iconName;
           $committee->cover = $coverName;
       }

       $committee->save();
       if ($committee->wasRecentlyCreated) {
           $committee->members()->create([
               'user_id' => $user->id,
               'position_id' => Position::where('name', 'Committee Member')->first()->id,
               'committee_id' =>  $committee->id,
           ]);
           $DefaultfolderNames = [
               "Committee Folders",
               "Committee Archives",
               "Meeting Folders",
           ];
           $this->folderRepository->createCommitteeDefaultFolder($committee, $DefaultfolderNames);
           // $user->notify(new CommitteeNewMemberNotification($user, $committee));
       }
       return $committee;
   }

   public function imageManage($payload, $committee, $peviousfileName = null)
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
   public function iconManage($payload, $committee, $peviousfileName = null)
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

   public function update(Committee|string $committee, array $payload): Committee
   {
       // dd('$payload', $committee, $payload);
       if (!($committee instanceof Committee)) {
           $committee = Committee::findOrFail($committee);
       }
       $previousIconFileName = $committee->icon;
       $previousCoverFileName = $committee->cover;
       $committee->tempUserIds = $committee->members()->pluck('user_id')->toArray();
       
       $committee->name        = $payload['name'];
       $committee->description = $payload['description'];
       $committee->status      = StatusEnum::Active->value;
    //    $committee->committeeable_id = $board->id;
    //    $committee->committeeable_type = 'board';
    //    $committee->owner()->associate($user);

       // Handle icon and cover updates if any changes are provided
       $iconName = $this->iconManage($payload, $committee, $previousIconFileName);
       if ($iconName) {
           $committee->icon = $iconName;
       }
       $coverName = $this->imageManage($payload, $committee, $previousCoverFileName);
       if ($coverName) {
           $committee->cover = $coverName;
       }
       $committee->save();
       return $committee;
   }

   public function updateMembers(Committee $committee, array $payload): Committee
   {
       if (!($committee instanceof Committee)) {
           $committee = Committee::findOrFail($committee);
       }

       $committee->tempMemberUpdates = $payload['members'];
       // dd($committee->tempMemberUpdates);
       $committee->save();
       $committee->touch();
       return $committee;
   }
   public function updateMemberPosition(Committee|string $committee, array $payload): Committee
   {
       if (!($committee instanceof Committee)) {
           $committee = Committee::findOrFail($committee);
       }

       $committee->tempMemberId = $payload['id'];
       $committee->tempMemberPosition   = $payload['position_id'];
       // dd($committee->tempMemberUpdates);
       $committee->save();
       $committee->touch();
       return $committee;
   }

   public function delete(Committee|string $committee)
   {
       if (!($committee instanceof Committee)) {
           $committee = Committee::findOrFail($committee);
       }
       $previousIconFileName = $committee->icon;
       $previousCoverFileName = $committee->cover;
       $iconfolderLocation = '/images/icon/';
       $coverfolderLocation = '/images/cover/';
       $deletedicon = make(ImageAction::class)->deleteImage($iconfolderLocation, $previousIconFileName);
       $deletecover = make(ImageAction::class)->deleteImage($coverfolderLocation, $previousCoverFileName);
       $this->folderRepository->deleteCommitteeFolders($committee);
       return $committee->delete();
   } // Implement the methods


}