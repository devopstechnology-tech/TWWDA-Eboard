<?php

declare(strict_types=1);

namespace App\Providers;

use Log;
use App\Models\Role;
use App\Models\User;
use App\Libs\MpesaLibrary;
use App\Models\Permission;
use App\Models\System\Otp;
use App\Models\Users\Staff;
use Carbon\CarbonImmutable;
use App\Models\General\Media;
use App\Models\Users\Profile;
use App\Models\Config\Setting;
use App\Models\General\Folder;
use App\Models\System\Almanac;
use App\Models\System\LoginLog;
use App\Observers\UserObserver;
use App\Models\Module\Poll\Poll;
use App\Models\Module\Task\Task;
use App\Observers\BoardObserver;
use App\Observers\StaffObserver;
use App\Services\SMS\AdvantaSMS;
use App\Services\SMS\MobiTechSMS;
use App\Models\Module\Board\Board;
use App\Models\System\ActivityLog;
use App\Observers\MeetingObserver;
use App\Repository\ChatRepository;
use App\Repository\PollRepository;
use App\Repository\RoleRepository;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Repository\VoteRepository;
use App\Models\System\Modification;
use App\Models\System\Notification;
use App\Observers\LoginLogObserver;
use App\Repository\BoardRepository;
use App\Repository\StaffRepository;
use App\Repository\UsersRepository;
use Illuminate\Support\Facades\URL;
use App\Models\Module\Member\Member;
use App\Models\Module\Poll\Sub\Vote;
use App\Observers\CommitteeObserver;
use App\Repository\AgendaRepository;
use App\Repository\FolderRepository;
use App\Repository\MemberRepository;
use App\Repository\MinuteRepository;
use App\Repository\OptionRepository;
use Illuminate\Support\Facades\Date;
use App\Models\Module\Meeting\Agenda;
use App\Models\Module\Meeting\Minute;
use App\Observers\MembershipObserver;
use App\Repository\AlmanacRepository;
use App\Repository\MeetingRepository;
use App\Repository\ProfileRepository;
use App\Repository\SettingRepository;
use App\Models\Module\Meeting\Meeting;
use App\Models\Module\Member\Position;
use App\Models\Module\Poll\Sub\Option;
use App\Models\System\LoginLogHistory;
use App\Models\System\PasswordHistory;
use App\Repository\ConflictRepository;
use App\Repository\PositionRepository;
use App\Repository\ScheduleRepository;
use App\Models\Module\Meeting\Schedule;
use App\Repository\CommitteeRepository;
use App\Services\SMS\AfricasTalkingSMS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Models\Module\Conflict\Conflict;
use App\Models\Module\Member\Attendance;
use App\Models\Module\Member\Membership;
use App\Models\Module\Poll\AssigneePoll;
use App\Repository\AttendanceRepository;
use App\Repository\DiscussionRepository;
use App\Repository\MembershipRepository;
use App\Services\Contracts\SmsInterface;
use App\Models\Module\Committe\Committee;
use App\Repository\ActivityLogRepository;
use App\Repository\AssigneePollRepository;
use App\Repository\AssigneeTaskRepository;
use App\Repository\DetailMinuteRepository;
use App\Repository\MeetingGuestRepository;
use App\Repository\MinuteReviewRepository;
use App\Repository\ModificationRepository;
use App\Repository\NotificationRepository;
use App\Models\Module\Discussions\Sub\Chat;
use App\Models\Module\Meeting\MeetingGuest;
use App\Models\System\PasswordResetRequest;
use App\Repository\Contracts\ChatInterface;
use App\Repository\Contracts\PollInterface;
use App\Repository\Contracts\RoleInterface;
use App\Repository\Contracts\TaskInterface;
use App\Repository\Contracts\UserInterface;
use App\Repository\Contracts\VoteInterface;
use App\Repository\MeetingMemberRepository;
use App\Models\Module\Meeting\MeetingMember;
use App\Models\Module\Task\Sub\AssigneeTask;
use App\Repository\AgendaAssigneeRepository;
use App\Repository\Contracts\BoardInterface;
use App\Repository\Contracts\StaffInterface;
use App\Repository\Contracts\UsersInterface;
use App\Models\Module\Discussions\Discussion;
use App\Repository\CommitteeMemberRepository;
use App\Repository\Contracts\AgendaInterface;
use App\Repository\Contracts\FolderInterface;
use App\Repository\Contracts\MemberInterface;
use App\Repository\Contracts\MinuteInterface;
use App\Repository\Contracts\OptionInterface;
use App\Repository\Contracts\AlmanacInterface;
use App\Repository\Contracts\MeetingInterface;
use App\Repository\Contracts\ProfileInterface;
use App\Repository\Contracts\SettingInterface;
use App\Models\Module\Committe\CommitteeMember;
use App\Models\Module\Meeting\Agenda\SubAgenda;
use App\Repository\Contracts\ConflictInterface;
use App\Repository\Contracts\PositionInterface;
use App\Repository\Contracts\ScheduleInterface;
use App\Repository\SubAgendaAssigneeRepository;
use App\Repository\Contracts\CommitteeInterface;
use App\Repository\DiscussionAssigneeRepository;
use App\Repository\Contracts\AttendanceInterface;
use App\Repository\Contracts\DiscussionInterface;
use App\Repository\Contracts\MembershipInterface;
use App\Models\Module\Meeting\Minute\DetailMinute;
use App\Models\Module\Meeting\Minute\MinuteReview;
use App\Repository\Contracts\ActivityLogInterface;
use App\Repository\Contracts\AssigneePollInterface;
use App\Repository\Contracts\AssigneeTaskInterface;
use App\Repository\Contracts\DetailMinuteInterface;
use App\Repository\Contracts\MeetingGuestInterface;
use App\Repository\Contracts\MinuteReviewInterface;
use App\Repository\Contracts\ModificationInterface;
use App\Repository\Contracts\NotificationInterface;
use App\Models\Module\Meeting\Agenda\AgendaAssignee;
use App\Repository\Contracts\MeetingMemberInterface;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Module\Meeting\Minute\SubDetailMinute;
use App\Repository\Contracts\AgendaAssigneeInterface;
use App\Repository\Contracts\CommitteeMemberInterface;
use App\Repository\Contracts\SubAgendaAssigneeInterface;
use App\Models\Module\Discussions\Sub\DiscussionAssignee;
use App\Repository\Contracts\DiscussionAssigneeInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Date::use(CarbonImmutable::class);
        Model::shouldBeStrict(!$this->app->isProduction());
        Relation::enforceMorphMap([
            'setting' => Setting::class,
            'activity_log' => ActivityLog::class,
            // 'staff' => Staff::class,
            'login_log' => LoginLog::class,
            'login_log_history' => LoginLogHistory::class,
            'otp' => Otp::class,
            'password_history' => PasswordHistory::class,
            'password_reset_request' => PasswordResetRequest::class,
            'permission' => Permission::class,
            'role' => Role::class,
            'user' => User::class,
            'profile' => Profile::class,
            'board' => Board::class,
            'member' => Member::class,
            'position' => Position::class,
            'committee' => Committee::class,
            'folder' => Folder::class,
            'membership' => Membership::class,
            'committeemember' => CommitteeMember::class,
            'agenda' => Agenda::class,
            'agendaassignee' => AgendaAssignee::class,
            'subagenda' => SubAgenda::class,
            'agendaassignee' => AgendaAssignee::class,
            'discussion' => Discussion::class,
            'discussionassignee' => DiscussionAssignee::class,
            'chat' => Chat::class,
            'meetingguest' => MeetingGuest::class,
            'meetingmember' => MeetingMember::class,
            'meeting' => Meeting::class,
            'conflict' => Conflict::class,
            'media' => Media::class,
            'minute' => Minute::class,
            'detailminute' => DetailMinute::class,
            'subdetailminute' => SubDetailMinute::class,
            'minutereview' => MinuteReview::class,
            'poll' => Poll::class,
            'assigneepoll' => AssigneePoll::class,
            'option' => Option::class,
            'vote' => Vote::class,
            'schedule' => Schedule::class,
            'task' => Task::class,
            'assigneetask' => AssigneeTask::class,
            'modification' => Modification::class,
            'almanac' => Almanac::class,
            'notification' => Notification::class,
            'attendance' => Attendance::class,
        ]);
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        User::observe(UserObserver::class);
        Board::observe(BoardObserver::class);
        Committee::observe(CommitteeObserver::class);
        Meeting::observe(MeetingObserver::class);
        Membership::observe(MembershipObserver::class);
        // Staff::observe(StaffObserver::class);
        LoginLog::observe(LoginLogObserver::class);
    }


    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ActivityLogInterface::class, ActivityLogRepository::class);
        $this->app->singleton(RoleInterface::class, RoleRepository::class);
        $this->app->singleton(StaffInterface::class, StaffRepository::class);
        $this->app->singleton(UserInterface::class, UserRepository::class);
        $this->app->singleton(ProfileInterface::class, ProfileRepository::class);
        $this->app->singleton(UsersInterface::class, UsersRepository::class);
        $this->app->singleton(SettingInterface::class, SettingRepository::class);
        $this->app->singleton(BoardInterface::class, BoardRepository::class);
        $this->app->singleton(ModificationInterface::class, ModificationRepository::class);
        $this->app->singleton(NotificationInterface::class, NotificationRepository::class);
        $this->app->singleton(MemberInterface::class, MemberRepository::class);
        $this->app->singleton(PositionInterface::class, PositionRepository::class);
        $this->app->singleton(MembershipInterface::class, MembershipRepository::class);
        $this->app->singleton(CommitteeInterface::class, CommitteeRepository::class);
        $this->app->singleton(CommitteeMemberInterface::class, CommitteeMemberRepository::class);
        $this->app->singleton(AgendaInterface::class, AgendaRepository::class);
        $this->app->singleton(AgendaAssigneeInterface::class, AgendaAssigneeRepository::class);
        $this->app->singleton(SubAgendaAssigneeInterface::class, SubAgendaAssigneeRepository::class);
        $this->app->singleton(DiscussionInterface::class, DiscussionRepository::class);
        $this->app->singleton(DiscussionAssigneeInterface::class, DiscussionAssigneeRepository::class);
        $this->app->singleton(ChatInterface::class, ChatRepository::class);
        $this->app->singleton(MeetingGuestInterface::class, MeetingGuestRepository::class);
        $this->app->singleton(MeetingMemberInterface::class, MeetingMemberRepository::class);
        $this->app->singleton(MeetingInterface::class, MeetingRepository::class);
        $this->app->singleton(ConflictInterface::class, ConflictRepository::class);
        $this->app->singleton(FolderInterface::class, FolderRepository::class);
        $this->app->singleton(MinuteInterface::class, MinuteRepository::class);
        $this->app->singleton(DetailMinuteInterface::class, DetailMinuteRepository::class);
        // $this->app->singleton(SubDetailMinuteInterface::class, SubDetailMinuteRepository::class);
        $this->app->singleton(MinuteReviewInterface::class, MinuteReviewRepository::class);
        $this->app->singleton(PollInterface::class, PollRepository::class);
        $this->app->singleton(AssigneePollInterface::class, AssigneePollRepository::class);
        $this->app->singleton(OptionInterface::class, OptionRepository::class);
        $this->app->singleton(VoteInterface::class, VoteRepository::class);
        $this->app->singleton(ScheduleInterface::class, ScheduleRepository::class);
        $this->app->singleton(TaskInterface::class, TaskRepository::class);
        $this->app->singleton(AssigneeTaskInterface::class, AssigneeTaskRepository::class);
        $this->app->singleton(AlmanacInterface::class, AlmanacRepository::class);
        $this->app->singleton(AttendanceInterface::class, AttendanceRepository::class);

        // $this->app->bind(SmsInterface::class, function ($app) {
        //     if (config('sms.sms') == 'Advanta') {
        //         return new AdvantaSMS();
        //     }
        //     if (config('sms.sms') == 'AT') {
        //         return new AfricasTalkingSMS();
        //     }

        //     return new MobiTechSMS();
        // });
        // $this->app->singleton('mpesa', function () {
        //     return new MpesaLibrary();
        // });
    }
}