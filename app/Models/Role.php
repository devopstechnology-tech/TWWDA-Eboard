<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Loggable;
use App\Traits\ProcessDelete;
use App\Traits\QueryFormatter;
use App\Traits\RequiresApproval;
use App\Traits\Types;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Role extends BaseModel
{
    use HasFactory;
    use ProcessDelete;
    use Loggable;
    use QueryFormatter;
    use Types;
    use RequiresApproval;
    protected function requiresApprovalWhen(array $modifications): bool
    {
        if (app()->environment() === 'testing') {
            return false;
        }

        return true;
    }
    protected static array $searchable = ['name'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted',
    ];
    protected array $loggable = ['*'];
    protected $withCount = ['permissions', 'users'];

    public function givePermissionTo(...$permissions): self
    {
        $permissions = collect($permissions)->flatten()->map(fn($permission) => ($permission instanceof Permission) ? $permission->id : $permission)->toArray();

        $this->permissions()->syncWithoutDetaching($permissions);

        return $this;
    }

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'model', 'model_has_permissions', 'model_id', 'permission_id');
    }

    public function hasTypePermissionTo(string $type, string $permissionName): bool
    {
        return $this->permissions()->where('type', $type)->where('name', $permissionName)->exists();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
    }
}
