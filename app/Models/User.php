<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Types;
use App\Traits\Uuids;
use App\Traits\Loggable;
use App\Models\BaseModel;
use App\Models\System\Otp;
use Illuminate\Support\Str;
use App\Models\Users\Profile;
use App\Mail\UserEmailChanged;
use App\Traits\QueryFormatter;
use App\Models\System\LoginLog;
use App\Traits\ApprovesChanges;
use App\Traits\RequiresApproval;
use App\Mail\PasswordChangedMail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Models\System\Modification;
use Laravel\Sanctum\NewAccessToken;
use App\Models\Module\Member\Member;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Models\System\PasswordHistory;
use App\Models\Module\Member\Membership;
use Illuminate\Notifications\Notifiable;
use App\Models\Module\Committe\Committee;
use App\Models\Module\Discussions\Sub\Chat;
use App\Models\Module\Discussions\Discussion;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Module\Discussions\Sub\DiscussionAssignee;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

//use App\Traits\UserTimeZoneAware;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, MustVerifyEmail
{
    use Loggable;
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use \Illuminate\Auth\MustVerifyEmail;
    use HasFactory;
    use ApprovesChanges;
    use Uuids;
    use Notifiable;

    //    use UserTimeZoneAware;
    use QueryFormatter;

    use HasApiTokens {
        HasApiTokens::createToken as createBaseToken;
    }
    use Types;

    use RequiresApproval;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static array $searchable = [
        'users.first',
        'users.last',
        'users.email',
        // 'users.phone',
        // 'users.id_number',
    ];
    protected array $loggable = ['*'];
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
        'updated_at',
        'deleted_at',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'readable_token' => 'encrypted',
    ];
    protected $fillable = ['first', 'last', 'other_names', 'email', 'password', 'role', 'status', 'last_login_at', 'last_login_ip'];
    protected $appends = ['full_name'];

    public static function boot(): void
    {
        parent::boot();
        static::updated(function ($model) {
            //            if ($model->wasChanged('email')) {
            //                Mail::queue(new UserEmailChanged(['user' => $model->only('first', 'last')], $model->email));
            //            }

            //            if ($model->wasChanged('password')) {
            //                Mail::queue(new PasswordChangedMail(['messageIsFor' => $model->only('first', 'last')], $model->email));
            //            }
        });
    }

    protected $with = ['roles.permissions'];

    public function getLastLoginAtAttribute($value): string
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first . ' ' . $this->last;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }
    public function hasSuperAdminRole(): bool
    {
        return $this->role === 'Super Admin'
            || $this->roles()
            ->where('name', 'Super Admin')
            ->where('type', self::$type_system)
            ->exists();
    }

    public function roles(): MorphToMany
    {
        return $this->morphToMany(
            Role::class,
            'model',
            'model_has_roles',
            'model_id',
            'role_id'
        );
    }
    public function permisions(): MorphToMany
    {
        return $this->morphToMany(
            Role::class,
            'model',
            'model_has_permissions',
            'model_id',
            'permission_id'
        );
    }

    public function loginLogs(): MorphMany
    {
        return $this->morphMany(LoginLog::class, 'login_loggable');
    }

    public function otps(): MorphMany
    {
        return $this->morphMany(Otp::class, 'otpable');
    }

    public function otp(): MorphOne
    {
        return $this->morphOne(Otp::class, 'otpable')->latestOfMany();
    }

    public function passwordHistories(): MorphMany
    {
        return $this->morphMany(PasswordHistory::class, 'password_loggable');
    }

    public function createToken(string $name, array $abilities = ['*']): NewAccessToken
    {
        // create token
        $token = $this->createBaseToken($name, $abilities);

        // encrypt (so we can decrypt later)
        // $token->plainTextToken = Crypt::encryptString(
        //     $token->plainTextToken
        // );
        // Encrypt the token (so we can decrypt later if necessary)
        $encryptedToken = Crypt::encryptString($token->plainTextToken);
        $this->user_token = $encryptedToken;
        // Update the user_token field in the database
        $this->save();
        $token->plainTextToken = $encryptedToken;
        return $token;
    }
    public function committees()
    {
        return $this->belongsToMany(Committee::class, 'committee_members', 'user_id', 'committee_id');
    }
    // public function boards()
    // {
    //     return $this->belongsToMany(Board::class, 'committee_members', 'user_id', 'committee_id');
    // }

    //new
    public function membership()
    {
        return $this->hasOne(Membership::class, 'user_id')
            ->with('attendances');
    }
    public function membs()
    {
        return $this->hasMany(Member::class, 'user_id');
    }
    public function members()
    {
        return $this->morphMany(Member::class, 'memberable');
    }

    public function scopeSystem($query)
    {
        return $query->where('type', self::$type_system);
    }

    public function scopeDefault($query)
    {
        return $query->where('type', self::$type_default);
    }
    public function setAttribute($key, $value): mixed
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

    // public function phone(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn(string $value) => formatPhoneNumber($value)
    //     );
    // }

    public function email(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => formatEmail($value)
        );
    }

    // public function idNumber(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn(string $value) => formatIdNumber($value)
    //     );
    // }

    public function assignRole($roles, $type = 'default'): void
    {
        $roles = collect($roles)->flatten();
        foreach ($roles as $role) {
            $roleObject = Role::firstOrCreate(['name' => $role, 'guard_name' => 'web', 'type' => $type]);
            DB::table('model_has_roles')->insert([
                'role_id' => $roleObject->id,
                'model_type' => self::class,
                'model_id' => $this->id,
            ]);
        }
    }

    public function hasRole($roles): bool
    {
        if (is_string($roles)) {
            $role = Role::where('name', $roles)->first();

            if (empty($role)) {
                return false;
            }

            return DB::table('model_has_roles')
                ->where('role_id', $role->id)
                ->where('model_type', self::class)
                ->where('model_id', $this->id)->exists();
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }

            return false;
        }

        return false;
    }

    // protected function requiresApprovalWhen(array $modifications): bool
    // {
    //     if (app()->environment() === 'testing') {
    //         return false;
    //     }
    //     if (array_key_exists('last_login_at', $modifications)) {
    //         return false;
    //     }

    //     return true;
    // }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => bcrypt($value)
        );
    }

    // protected function authorizedToApprove(Modification $modification): bool
    // {
    //     // Return true to authorize approval, false to deny
    //     if (request()->user()->role === 'Super Admin') {
    //         return true;
    //     }
    //     if ($modification->modifier_id === $this->id) {
    //         return false;
    //     }

    //     return true;
    // }

    protected function authorizedToDisapprove(Modification $modification): bool
    {
        // Return true to authorize disapproval, false to deny
        //        if (request()->user()->role === 'SuperAdmin') {
        //            return true;
        //        }

        return true;
    }
    
    public function discussions()
    {
        return $this->hasMany(Discussion::class, 'user_id');
    }

    public function sentChats()
    {
        return $this->hasMany(Chat::class, 'assignee_sender_id');
    }

    public function receivedChats()
    {
        return $this->hasMany(Chat::class, 'assignee_receiver_id');
    }

    // public function discussionAssignees()
    // {
    //     return $this->morphMany(DiscussionAssignee::class, 'assignable_id');
    // }
    public function assigneeDiscussions()
    {
        return $this->morphMany(DiscussionAssignee::class, 'assignable');
    }
}