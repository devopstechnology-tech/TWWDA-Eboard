<?php

declare(strict_types=1);

use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\RoleController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\v1\PermissionController;
use App\Http\Controllers\v1\Staff\Users\UserController;
use App\Http\Controllers\v1\Modules\Poll\PollController;
use App\Http\Controllers\v1\Modules\Task\TaskController;
use App\Http\Controllers\v1\Staff\Users\StaffController;
use App\Http\Controllers\v1\Modules\User\UsersController;
use App\Http\Controllers\v1\Modules\Board\BoardController;
use App\Http\Controllers\v1\Modules\User\ProfileController;
use App\Http\Controllers\v1\Modules\Member\MemberController;
use App\Http\Controllers\v1\Modules\Config\SettingController;
use App\Http\Controllers\v1\Modules\General\FolderController;
use App\Http\Controllers\v1\Modules\Meeting\AgendaController;
use App\Http\Controllers\v1\Modules\Meeting\MinuteController;
use App\Http\Controllers\v1\Modules\General\AlmanacController;
use App\Http\Controllers\v1\Modules\Meeting\MeetingController;
use App\Http\Controllers\v1\Modules\Member\PositionController;
use App\Http\Controllers\v1\Modules\Discussions\ChatController;
use App\Http\Controllers\v1\Modules\Meeting\ScheduleController;
use App\Http\Controllers\v1\Staff\System\ActivityLogController;
use App\Http\Controllers\v1\Modules\Board\BoardMemberController;
use App\Http\Controllers\v1\Modules\Conflict\ConflictController;
use App\Http\Controllers\v1\Modules\Member\AttendanceController;
use App\Http\Controllers\v1\Modules\User\NotificationController;
use App\Http\Controllers\v1\Modules\Meeting\MembershipController;
use App\Http\Controllers\v1\Modules\Committee\CommitteeController;
use App\Http\Controllers\v1\Modules\Meeting\MeetingGuestController;
use App\Http\Controllers\v1\Modules\Meeting\MeetingMemberController;
use App\Http\Controllers\v1\Modules\Discussions\DiscussionController;
use App\Http\Controllers\v1\Modules\Committee\CommitteeMemberController;

Route::group(['prefix' => 'v1'], function () {
    // //////////////////// GLOBAL ROUTES FOR API ////////////
    Route::get('auth', [UserController::class, 'auth'])->middleware('token.decrypt', 'auth:sanctum');

    // //////////////////// AUTHENTICATION ROUTES ///////////////////////
    Route::group(['as' => 'web.'], function () {
        Route::post('register', [UserController::class, 'register'])->name('register');
        Route::post('users/acceptance/{acceptance}', [UsersController::class, 'inviteaccept']);
        // Route::post('login', function () {
        //     dd('Route is working');
        // });
        Route::post('login', [UserController::class, 'login']);
        Route::post('reset-password', [UserController::class, 'forgotPassword'])->name('reset-password');
        Route::post('change-password', [UserController::class, 'changePassword'])->name('change-password');
        Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
        Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

        // //////////////////// AUTHENTICATED ROUTES ///////////////////////
        Route::group(['middleware' => ['token.decrypt', 'auth:sanctum', 'verified-email']], function () {
            Route::post('logout', [UserController::class, 'logout'])->name('logout');

            Route::apiResource('activity-logs', ActivityLogController::class)->except('store', 'update');
            Route::apiResource('permissions', PermissionController::class);
            Route::apiResource('staff', StaffController::class);

            Route::apiResource('user', UserController::class);

            // custom
            //setings
            Route::get('settings', [SettingController::class, 'get']);
            Route::get('settings/mailtypes', [SettingController::class, 'getmailtypes']);
            Route::post('settings/update/{setting}', [SettingController::class, 'update']);
            // api/v1/users
            Route::get('users', [UsersController::class, 'index']);
            Route::get('users/trashedusers', [UsersController::class, 'trashedusers']);
            Route::get('users/{user}', [UsersController::class, 'show']);
            Route::post('users/create', [UsersController::class, 'store']);
            Route::post('users/update/{user}', [UsersController::class, 'update']);
            Route::post('users/role/update/{user}', [UsersController::class, 'updaterole']);
            Route::post('users/delete/{user}', [UsersController::class, 'destroy']);
            Route::post('users/restore/delete/{user}', [UsersController::class, 'restore']);
            Route::post('users/force/delete/{user}', [UsersController::class, 'force']);

            //////////////////////////// profiel/////////////////
            Route::get('profiles/{profile}', [ProfileController::class, 'show']);
            Route::post('profiles/update/{profile}', [ProfileController::class, 'update']);

            //////////////////////////// Board/////////////////
            Route::get('boards/latest', [BoardController::class, 'latest']);
            Route::post('boards/update/{board}', [BoardController::class, 'update']);
            Route::post('boards/members/{board}', [BoardController::class, 'updatemembers']);
            Route::apiResource('boards', BoardController::class);
           
             //////////////////////////// Committee/////////////////
            //  Route::apiResource('committees', CommitteeController::class);
             Route::get('committees', [CommitteeController::class, 'index']);
             Route::get('committees/latest', [CommitteeController::class, 'latest']);
             Route::get('committees/{board}', [CommitteeController::class, 'boardcommittee']);
            //  Route::get('committees/{committee}', [CommitteeController::class, 'show']);
             Route::post('committees/create/{board}', [CommitteeController::class, 'store']);
             Route::post('committees/update/{committee}', [CommitteeController::class, 'update']);
             Route::post('committees/members/{board}/{committee}', [CommitteeController::class, 'updatemembers']);
 
            // members
            Route::get('members/board/{board}', [MemberController::class, 'getboardmembers']);
            Route::post('members/board/update/members/{board}', [MemberController::class, 'updateboardmembers']);
            Route::post('members/board/update/member/position/{board}', [MemberController::class, 'updateboardmemberposition']);
            Route::get('members/committee/{committee}', [MemberController::class, 'getcommitteemembers']);
            Route::post('members/committee/update/members/{committee}', [MemberController::class, 'updatecommitteemembers']);
            Route::post('members/committee/update/member/position/{committee}', [MemberController::class, 'updatecommitteememberposition']);




            // positions
            Route::get('positions/board', [PositionController::class, 'board']);
            Route::get('positions/committee', [PositionController::class, 'committee']);
            Route::get('positions/meeting', [PositionController::class, 'meeting']);
           



            ///////////////////////////////board meeting//////////////////
            Route::apiResource('agendas', AgendaController::class);
            Route::get('agendas/schedule/previous', [AgendaController::class, 'latestscheduleagendas']); //ageands for specific schedule
            Route::get('agendas/schedule/previous/accept/{oldschedule}/{newschedule}', [AgendaController::class, 'acceptlatestscheduleagendas']); //ageands for specific schedule
            Route::get('agendas/schedule/{schedule}', [AgendaController::class, 'scheduleagendas']); //ageands for specific schedule
            Route::post('agendas/schedule/create/{schedule}', [AgendaController::class, 'store']); //ageands for specific schedule
            Route::post('agendas/schedule/create/subagenda/{schedule}', [AgendaController::class, 'createsubagenda']); //ageands for specific schedule
            Route::post('agendas/schedule/update/agenda/{schedule}', [AgendaController::class, 'update']); //ageands for specific schedule
            Route::post('agendas/schedule/update/agenda/subagenda/{schedule}', [AgendaController::class, 'updatesubagenda']); //ageands for specific schedule
            Route::post('agendas/schedule/delete/agenda/subagenda/{subagenda}', [AgendaController::class, 'deletesubagenda']); //ageands for specific schedule
            Route::post('agendas/schedule/delete/agenda/{agenda}', [AgendaController::class, 'deleteagenda']); //ageands for specific schedule


            ///////////////////////////////meeting Minutes//////////////////
            Route::apiResource('minutes', MinuteController::class);
            Route::get('minutes/schedule/{schedule}', [MinuteController::class, 'meetingminute']);
            Route::post('minutes/schedule/create/{schedule}', [MinuteController::class, 'store']);
            Route::post('minutes/schedule/create/subminute/{schedule}', [MinuteController::class, 'createsubminute']);
            Route::post('minutes/schedule/update/minute/{meeting}', [MinuteController::class, 'update']);
            Route::post('minutes/schedule/update/minute/subminute/{meeting}', [MinuteController::class, 'updatesubminute']);
            Route::patch('minutes/schedule/ceo/approval/{minutes}', [MinuteController::class, 'ceoapproval']);
            Route::patch('minutes/schedule/ceo/accept/approval/{minutes}', [MinuteController::class, 'acceptapproval']);
            Route::patch('minutes/schedule/publish/{minutes}', [MinuteController::class, 'publish']);
            Route::patch('minutes/schedule/signatures/{minutes}', [MinuteController::class, 'signatures']);
            Route::delete('minutes/schedule/delete/{minutes}', [MinuteController::class, 'destroy']);




            Route::apiResource('meetingGuests', MeetingGuestController::class);
            Route::apiResource('meetingMembers', MeetingMemberController::class);

            Route::apiResource('meetings', MeetingController::class);
            Route::get('meeting', [MeetingController::class, 'index']);
            Route::get('meeting/latest', [MeetingController::class, 'latest']);
            Route::get('meeting/board/{board}', [MeetingController::class, 'boardmeeting']);
            Route::get('meetings/board/{board}', [MeetingController::class, 'boardmeetings']);            
            Route::post('meetings/board', [MeetingController::class, 'store']);
            Route::patch('meetings/board/meeting/{board}', [MeetingController::class, 'update']);
            //committee
            Route::get('meeting/committee/{committee}', [MeetingController::class, 'committeemeeting']);
            Route::get('meetings/committee/{committee}', [MeetingController::class, 'committeemeetings']);
            Route::post('meetings/committee', [MeetingController::class, 'store']);
            Route::patch('meetings/committee/meeting/{committee}', [MeetingController::class, 'update']);
            Route::patch('meetings/publish/{meeting}', [MeetingController::class, 'publish']);

            //////////////////////////// scdeulesh/////////////////
            Route::get('schedules', [ScheduleController::class, 'index']);
            Route::get('schedules/latest', [ScheduleController::class, 'latest']);
            Route::get('schedules/{meeting}', [ScheduleController::class, 'schedule']);
            Route::post('schedules/show/{schedule}', [ScheduleController::class, 'show']);
            Route::post('schedules', [ScheduleController::class, 'store']);
            Route::patch('schedules/update/{schedule}', [ScheduleController::class, 'update']);
            Route::post('schedules/close/{schedule}', [ScheduleController::class, 'close']);
            Route::delete('schedules/{schedule}', [ScheduleController::class, 'destroy']);



            //////////////////////////// memberships/////////////////
            Route::get('memberships/meeting/{meeting}', [MembershipController::class, 'getmeetingmemberships']);
            Route::post('memberships/update/meeting/{meeting}/schedule/{schedule}', [MembershipController::class, 'updatememberships']);
            Route::post('memberships/update/membership/position/{membership}/schedule/{schedule}', [MembershipController::class, 'updateposition']);

            // api/v1/attendances
            Route::get('attendances', [AttendanceController::class, 'index']);
            Route::get('attendances/signature/{attendance}/{mediaId}', [AttendanceController::class, 'getsignaturefile']);
            Route::post('attendances/update/signature/{attendance}/{mediaId}', [AttendanceController::class, 'updatesignature']);
            Route::get('attendances/schedule/{schedule}', [AttendanceController::class, 'show']);
            Route::post('attendances/create/{meeting}', [AttendanceController::class, 'store']);
            Route::post('attendances/reminder/{attendance}', [AttendanceController::class, 'reminder']);
            Route::post('attendances/delete/{attendance}', [AttendanceController::class, 'destroy']);
            Route::post('attendances/creatersvp/{attendance}', [AttendanceController::class, 'creatersvp']);
            Route::post('attendances/updatersvp/{attendance}', [AttendanceController::class, 'updatersvp']);
            Route::post('attendances/signattendance/{attendance}', [AttendanceController::class, 'signattendance']);

            Route::apiResource('tasks', TaskController::class);
            Route::get('tasks/latest', [TaskController::class, 'latest']);
            Route::get('tasks/meeting/{meeting}', [TaskController::class, 'getmeetingtasks']);
            Route::post('tasks/meeting/create/{meeting}', [TaskController::class, 'createmeetingtask']);
            Route::patch('tasks/meeting/update/{meeting}/{task}', [TaskController::class, 'updatemeetingtask']);
            Route::patch('tasks/meeting/update/{meeting}', [TaskController::class, 'updatetask']);
            
            Route::get('tasks/board/{board}', [TaskController::class, 'getboardtasks']);
            Route::post('tasks/board/create/{board}', [TaskController::class, 'createboardtask']);
            Route::patch('tasks/board/update/{task}', [TaskController::class, 'updateboardtask']);

            Route::get('tasks/committee/{committee}', [TaskController::class, 'getcommitteetasks']);
            Route::post('tasks/committee/create/{committee}', [TaskController::class, 'createcommitteetask']);
            Route::patch('tasks/committee/update/{task}', [TaskController::class, 'updatecommitteetask']);



            

            //////////////////////////// polls/////////////////
            Route::apiResource('polls', PollController::class);
            Route::get('polls/latest', [PollController::class, 'latest']);
            Route::post('polls/vote/{poll}', [PollController::class, 'votepoll']);

            Route::get('polls/meeting/{meeting}', [PollController::class, 'getmeetingpolls']);            
            Route::post('polls/meeting/create/{meeting}', [PollController::class, 'createmeetingpoll']);
            Route::patch('polls/meeting/update/{meeting}/{poll}', [PollController::class, 'updatemeetingpoll']);
            Route::patch('polls/meeting/update/{meeting}', [PollController::class, 'updatepoll']);
            
            Route::get('polls/board/{board}', [PollController::class, 'getboardpolls']);
            Route::post('polls/board/create/{board}', [PollController::class, 'createboardpoll']);
            Route::patch('polls/board/update/{poll}', [PollController::class, 'updateboardpoll']);

            Route::get('polls/committee/{committee}', [PollController::class, 'getcommitteepolls']);
            Route::post('polls/committee/create/{committee}', [PollController::class, 'createcommitteepoll']);
            Route::patch('polls/committee/update/{poll}', [PollController::class, 'updatecommitteepoll']);



            
            
            // discussions
            Route::get('discussions', [DiscussionController::class, 'index']);
            Route::get('discussions/{user}', [DiscussionController::class, 'userdiscussions']);
            Route::post('discussions/{user}', [DiscussionController::class, 'store']);
            Route::patch('discussions/update/{discussion}', [DiscussionController::class, 'update']);
            Route::patch('discussions/update/member/{discussion}', [DiscussionController::class, 'updatemember']);
            Route::get('discussions/leave/{discussion}', [DiscussionController::class, 'leave']);
            Route::get('discussions/close/{discussion}', [DiscussionController::class, 'close']);
            Route::get('discussions/delete/{discussion}', [DiscussionController::class, 'delete']);


            //chat 
            Route::post('chats/{member}', [ChatController::class, 'store']);
            Route::patch('chats/update/{chat}', [ChatController::class, 'update']);
      
      
            //////////////////////////// folders/////////////////
            Route::apiResource('folders', FolderController::class);
            //////////////////////////// superadin all folders/////////////////
            //////////////////////////// board folders/////////////////
            Route::get('folders/board/{board}', [FolderController::class, 'getboardfolders']);
            Route::post('folders/board/create/{board}', [FolderController::class, 'createboardfolder']);
            Route::patch('folders/board/update/{board}/{folder}', [FolderController::class, 'updateboardfolder']);
            Route::post('folders/board/file/create/{board}', [FolderController::class, 'createboardfilefolder']);
            Route::post('folders/board/file/update/{board}/{file}', [FolderController::class, 'updateboardfilefolder']);

              //////////////////////////// committee folders/////////////////
            Route::get('folders/committee/{committee}', [FolderController::class, 'getcommitteefolders']);
            Route::post('folders/committee/create/{committee}', [FolderController::class, 'createcommitteefolder']);
            Route::patch('folders/committee/update/{committee}/{folder}', [FolderController::class, 'updatecommitteefolder']);
            Route::post('folders/committee/file/create/{committee}', [FolderController::class, 'createcommitteefilefolder']);
            Route::post('folders/committee/file/update/{committee}/{file}', [FolderController::class, 'updatecommitteefilefolder']);




            //////////////////////////// folders/////////////////
            Route::get('folders/meeting/{meeting}', [FolderController::class, 'getmeetingfolders']);
            Route::post('folders/meeting/create/{meeting}', [FolderController::class, 'createmeetingfolder']);
            Route::patch('folders/meeting/update/{meeting}', [FolderController::class, 'updatemeetingfolder']);
            Route::post('folders/meeting/file/create/{meeting}', [FolderController::class, 'createmeetingfilefolder']);
            Route::post('folders/meeting/file/update/{meeting}', [FolderController::class, 'updatemeetingfilefolder']);
            Route::patch('folders/meeting/update/{meeting}', [FolderController::class, 'updatefolder']);

            /////////////////////////// files/////////////////
            Route::get('folders/{folder}/file/{file}', [FolderController::class, 'getfile']);
            Route::post('folders/update/{folder}/file/{file}', [FolderController::class, 'updatefile']);


            //////////////////////////// conflicts/////////////////
            Route::get('conflicts/meeting/{meeting}', [ConflictController::class, 'getmeetingconflicts']);
            Route::post('conflicts/meeting/create/{meeting}', [ConflictController::class, 'createmeetingconflict']);
            Route::patch('conflicts/meeting/update/{meeting}/{conflict}', [ConflictController::class, 'updatemeetingconflict']);

            //////////////////////////// notifications/////////////////
            Route::get('notifications', [NotificationController::class, 'index']);
            Route::get('notifications/{user}', [NotificationController::class, 'getnotifications']);
            Route::post('notifications/update/{notification}', [NotificationController::class, 'updatenotification']);

            //////////////////////////// almanacs/////////////////
            Route::get('almanacs', [AlmanacController::class, 'index']);
            Route::get('almanacs/latest', [AlmanacController::class, 'latest']);
            Route::post('almanacs/export/{export}', [AlmanacController::class, 'export']);
            Route::post('almanacs/import', [AlmanacController::class, 'import']);
            Route::post('almanacs/create', [AlmanacController::class, 'store']);
            Route::post('almanacs/update/{almanac}', [AlmanacController::class, 'update']);
            Route::post('almanacs/approve/{almanac}', [AlmanacController::class, 'approve']);
            Route::post('almanacs/held/{almanac}', [AlmanacController::class, 'markheldalmanac']);
            Route::post('almanacs/cancelled/{almanac}', [AlmanacController::class, 'markcancelledalmanac']);
            Route::post('almanacs/postponed/{almanac}', [AlmanacController::class, 'markpostponedalmanac']);
            Route::patch('almanacs/delete/{almanac}', [AlmanacController::class, 'delete']);




            Route::apiResource('roles', RoleController::class);
            Route::post('roles/{role}/attach/{permission}', [RoleController::class, 'attachPermissionToRole']);
            Route::post('roles/{role}/attach/{user}', [RoleController::class, 'attachRoleToUser']);
            Route::post('roles/{role}/detach/{permission}', [RoleController::class, 'detachPermissionFromRole']);
            Route::post('roles/{role}/detach/{user}', [RoleController::class, 'detachRoleFromUser']);

            Route::apiResource('roles', RoleController::class);
            Route::post('roles/{role}/attach/permission/{permission}', [RoleController::class, 'attachPermissionToRole'])->name('attach-permission-to-role');
            Route::delete('roles/{role}/detach/permission/{permission}', [RoleController::class, 'detachPermissionFromRole'])->name('detach-permission-to-role');
            Route::post('roles/{role}/attach/user/{user}', [RoleController::class, 'attachRoleToUser'])->name('attach-user-to-role');
            Route::delete('roles/{role}/detach/user/{user}', [RoleController::class, 'detachRoleFromUser'])->name('detach-user-to-role');
        });
    });
});


// php artisan make:model Module/Member/Attendance -m
// php artisan make:request Position -u
// php artisan make:controller v1/Modules/Member/PositionController
// php artisan make:Repository Position
// php artisan make:resource Position

// php artisan make:model Module/Discussion/Discussion -m
// php artisan make:request Discussion -u
// php artisan make:controller v1/Modules/Discussion/DiscussionController
// php artisan make:Repository Discussion
// php artisan make:resource Discussion
// php artisan make:model Module/Discussion/Sub/DiscussionAssignee -m
// php artisan make:request DiscussionAssignee -u
// php artisan make:controller v1/Modules/Discussion/DiscussionAssigneeController
// php artisan make:Repository DiscussionAssignee
// php artisan make:resource DiscussionAssignee
// php artisan make:model Module/Discussion/Sub/Chat -m
// php artisan make:request Chat -u
// php artisan make:controller v1/Modules/Discussion/ChatController
// php artisan make:Repository Chat
// php artisan make:resource Chat