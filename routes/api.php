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
use App\Http\Controllers\v1\Modules\Meeting\ScheduleController;
use App\Http\Controllers\v1\Staff\System\ActivityLogController;
use App\Http\Controllers\v1\Modules\Board\BoardMemberController;
use App\Http\Controllers\v1\Modules\Conflict\ConflictController;
use App\Http\Controllers\v1\Modules\Member\AttendanceController;
use App\Http\Controllers\v1\Modules\User\NotificationController;
use App\Http\Controllers\v1\Modules\Meeting\DiscussionController;
use App\Http\Controllers\v1\Modules\Meeting\MembershipController;
use App\Http\Controllers\v1\Modules\Committee\CommitteeController;
use App\Http\Controllers\v1\Modules\Meeting\MeetingGuestController;
use App\Http\Controllers\v1\Modules\Meeting\MeetingMemberController;
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
            Route::get('users/{user}', [UsersController::class, 'show']);
            Route::post('users/create', [UsersController::class, 'store']);
            Route::post('users/update/{user}', [UsersController::class, 'update']);
            Route::post('users/delete/{user}', [UsersController::class, 'destroy']);

            //////////////////////////// profiel/////////////////
            Route::get('profiles/{profile}', [ProfileController::class, 'show']);
            Route::post('profiles/update/{profile}', [ProfileController::class, 'update']);

            //////////////////////////// Board/////////////////
            Route::apiResource('boards', BoardController::class);
            Route::post('boards/update/{board}', [BoardController::class, 'update']);
            Route::post('boards/members/{board}', [BoardController::class, 'updatemembers']);
            Route::apiResource('boardmembers', BoardMemberController::class);
            // members
            Route::get('members/board/{board}', [MemberController::class, 'getboardmembers']);
            Route::post('members/board/update/members/{board}', [MemberController::class, 'updateboardmembers']);
            Route::post('members/board/update/member/role/{board}', [MemberController::class, 'updateboardmemberrole']);

            //////////////////////////// Committee/////////////////
            Route::apiResource('committees', CommitteeController::class);
            Route::post('committees/members/{committee}', [CommitteeController::class, 'updatememmbers']);
            Route::apiResource('committeemembers', CommitteeMemberController::class);


            ///////////////////////////////board meeting//////////////////
            Route::apiResource('agendas', AgendaController::class);
            Route::get('agendas/meeting/previous', [AgendaController::class, 'latestmeetingagendas']); //ageands for specific meeting
            Route::get('agendas/meeting/previous/accept/{oldmeeting}/{newmeeting}', [AgendaController::class, 'acceptlatestmeetingagendas']); //ageands for specific meeting
            Route::get('agendas/meeting/{meeting}', [AgendaController::class, 'meetingagendas']); //ageands for specific meeting
            Route::post('agendas/meeting/create/{meeting}', [AgendaController::class, 'store']); //ageands for specific meeting
            Route::post('agendas/meeting/create/subagenda/{meeting}', [AgendaController::class, 'createsubagenda']); //ageands for specific meeting
            Route::post('agendas/meeting/update/agenda/{meeting}', [AgendaController::class, 'update']); //ageands for specific meeting
            Route::post('agendas/meeting/update/agenda/subagenda/{meeting}', [AgendaController::class, 'updatesubagenda']); //ageands for specific meeting
            Route::post('agendas/meeting/delete/agenda/subagenda/{subagenda}', [AgendaController::class, 'deletesubagenda']); //ageands for specific meeting
            Route::post('agendas/meeting/delete/agenda/{agenda}', [AgendaController::class, 'deleteagenda']); //ageands for specific meeting

            ///////////////////////////////meeting Minutes//////////////////
            Route::apiResource('minutes', MinuteController::class);
            Route::get('minutes/meeting/{meeting}', [MinuteController::class, 'meetingminutes']);
            Route::post('minutes/meeting/create/{meeting}', [MinuteController::class, 'store']);
            Route::post('minutes/meeting/create/subminute/{meeting}', [MinuteController::class, 'createsubminute']);
            Route::post('minutes/meeting/update/minute/{meeting}', [MinuteController::class, 'update']);
            Route::post('minutes/meeting/update/minute/subminute/{meeting}', [MinuteController::class, 'updatesubminute']);




            Route::apiResource('discussions', DiscussionController::class);
            Route::apiResource('meetingGuests', MeetingGuestController::class);
            Route::apiResource('meetingMembers', MeetingMemberController::class);

            Route::apiResource('meetings', MeetingController::class);
            Route::get('meeting', [MeetingController::class, 'index']);
            Route::get('meeting/board/{board}', [MeetingController::class, 'boardmeeting']);
            Route::get('meetings/board/{board}', [MeetingController::class, 'boardmeetings']);
            Route::get('meeting/committee/{committee}', [MeetingController::class, 'committeemeeting']);
            Route::get('meetings/committee/{committee}', [MeetingController::class, 'committeemeetings']);
            Route::post('meetings/board', [MeetingController::class, 'store']);
            Route::patch('meetings/board/meeting/{board}', [MeetingController::class, 'update']);
            Route::post('meetings/committee', [MeetingController::class, 'store']);
            Route::patch('meetings/committee/meeting/{committee}', [MeetingController::class, 'update']);
            Route::patch('meetings/publish/{meeting}', [MeetingController::class, 'publish']);

            //////////////////////////// memberships/////////////////
            Route::get('memberships/meeting/{meeting}/board/{board}', [MembershipController::class, 'getmeetingboardmemberships']);
            Route::post('memberships/update/meeting/{meeting}/board/{board}', [MembershipController::class, 'updatemeetingboardmemberships']);

            // api/v1/attendances
            Route::get('attendances', [AttendanceController::class, 'index']);
            Route::get('attendances/meeting/{attendance}', [AttendanceController::class, 'show']);
            Route::post('attendances/create/{meeting}', [AttendanceController::class, 'store']);
            Route::post('attendances/update/{attendance}', [AttendanceController::class, 'update']);
            Route::post('attendances/delete/{attendance}', [AttendanceController::class, 'destroy']);
            Route::post('attendances/creatersvp/{attendance}', [AttendanceController::class, 'creatersvp']);
            Route::post('attendances/updatersvp/{attendance}', [AttendanceController::class, 'updatersvp']);
            Route::post('attendances/signattendance/{attendance}', [AttendanceController::class, 'signattendance']);



            Route::apiResource('schedules', ScheduleController::class);
            Route::apiResource('tasks', TaskController::class);
            Route::get('tasks/meeting/{meeting}', [TaskController::class, 'getmeetingtasks']);
            Route::post('tasks/meeting/create/{meeting}/board/{board}', [TaskController::class, 'createmeetingtask']);
            Route::patch('tasks/meeting/update/{meeting}/board/{board}/{task}', [TaskController::class, 'updatemeetingtask']);
            Route::patch('tasks/meeting/update/{meeting}', [TaskController::class, 'updatetask']);

            //////////////////////////// folders/////////////////
            Route::apiResource('folders', FolderController::class);
            //////////////////////////// superadin all folders/////////////////
            //////////////////////////// board folders/////////////////
            Route::get('folders/board/{board}', [FolderController::class, 'getboardfolders']);
            Route::post('folders/board/create/{board}', [FolderController::class, 'createboardfolder']);
            Route::patch('folders/board/update/{board}/{folder}', [FolderController::class, 'updateboardfolder']);
            Route::post('folders/board/file/create/{board}', [FolderController::class, 'createboardfilefolder']);
            Route::post('folders/board/file/update/{board}/{file}', [FolderController::class, 'updateboardfilefolder']);


            //////////////////////////// folders/////////////////
            Route::get('folders/meeting/{meeting}', [FolderController::class, 'getmeetingfolders']);
            Route::post('folders/meeting/create/{meeting}/board/{board}', [FolderController::class, 'createmeetingfolder']);
            Route::patch('folders/meeting/update/{meeting}/board/{board}', [FolderController::class, 'updatemeetingfolder']);
            Route::post('folders/meeting/file/create/{meeting}/board/{board}', [FolderController::class, 'createmeetingfilefolder']);
            Route::post('folders/meeting/file/update/{meeting}/board/{board}', [FolderController::class, 'updatemeetingfilefolder']);
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
            Route::post('almanacs/export/{export}', [AlmanacController::class, 'export']);
            Route::post('almanacs/import', [AlmanacController::class, 'import']);
            Route::post('almanacs/create', [AlmanacController::class, 'store']);
            Route::post('almanacs/update/{almanac}', [AlmanacController::class, 'update']);
            Route::post('almanacs/approve/{almanac}', [AlmanacController::class, 'approve']);
            Route::post('almanacs/held/{almanac}', [AlmanacController::class, 'markheldalmanac']);
            Route::post('almanacs/cancelled/{almanac}', [AlmanacController::class, 'markcancelledalmanac']);
            Route::post('almanacs/postponed/{almanac}', [AlmanacController::class, 'markpostponedalmanac']);
            Route::patch('almanacs/delete/{almanac}', [AlmanacController::class, 'delete']);




            //////////////////////////// polls/////////////////
            Route::apiResource('polls', PollController::class);
            Route::get('polls/meeting/{meeting}', [PollController::class, 'getmeetingpolls']);
            Route::post('polls/meeting/create/{meeting}/board/{board}', [PollController::class, 'createmeetingpoll']);
            Route::patch('polls/meeting/update/{meeting}/board/{board}/{poll}', [PollController::class, 'updatemeetingpoll']);
            Route::post('polls/meeting/update/{meeting}/board/{board}', [PollController::class, 'updatemeetingpoll']);


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
// php artisan make:request SubAgendaAssignee -u
// php artisan make:controller v1/Modules/Agenda/SubAgendaAssigneeController
// php artisan make:Repository SubAgendaAssignee
// php artisan make:resource SubAgendaAssignee
// php artisan make:request AgendaAssignee -u
// php artisan make:controller v1/Modules/Agenda/AgendaAssigneeController
// php artisan make:Repository AgendaAssignee
// php artisan make:resource AgendaAssignee