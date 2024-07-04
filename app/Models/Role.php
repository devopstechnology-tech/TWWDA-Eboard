<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Loggable;
use App\Traits\ProcessDelete;
use App\Traits\QueryFormatter;
use App\Traits\Types;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\RoleAlreadyExists;

class Role extends BaseModel implements RoleContract
{
    use HasFactory, ProcessDelete, Loggable, QueryFormatter, Types, SoftDeletes;

    protected $guarded = [
        'id'
    ];
    protected static array $searchable = [
        'name'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $withCount = [
        'permissions',
        'users'
    ];

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'model', 'model_has_permissions', 'model_id', 'permission_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function givePermissionTo(...$permissions): self
    {
        $permissions = collect($permissions)->flatten()->map(function ($permission) {
            return $permission instanceof Permission ? $permission->id : $permission;
        })->toArray();

        $this->permissions()->syncWithoutDetaching($permissions);

        return $this;
    }

    public function hasPermissionTo($permission, $guardName = null): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    public function hasTypePermissionTo(string $type, string $permissionName): bool
    {
        return $this->permissions()->where('type', $type)->where('name', $permissionName)->exists();
    }

    public static function findByName(string $name, $guardName = null): RoleContract
    {
        $role = static::where('name', $name)->where('guard_name', $guardName)->first();

        if (!$role) {
            throw RoleDoesNotExist::named($name);
        }

        return $role;
    }

    public static function findById($id, $guardName = null): RoleContract
    {
        $role = static::where('id', $id)->where('guard_name', $guardName)->first();

        if (!$role) {
            throw RoleDoesNotExist::withId($id);
        }

        return $role;
    }

    public static function findOrCreate(string $name, $guardName = null): RoleContract
    {
        $role = static::where('name', $name)->where('guard_name', $guardName)->first();

        if (!$role) {
            return static::create(['name' => $name, 'guard_name' => $guardName]);
        }

        return $role;
    }
}
