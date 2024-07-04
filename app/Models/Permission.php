<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Role;
use App\Traits\Types;
use App\Traits\Loggable;
use Spatie\Permission\Guard;
use App\Traits\ProcessDelete;
use App\Traits\QueryFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Permission\Contracts\Permission as PermissionContract;

class Permission extends BaseModel implements PermissionContract
{
    use HasFactory, Types, Loggable, QueryFormatter, ProcessDelete, SoftDeletes;

    protected $guarded = [
        'id'
    ];
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
        'guard_name'
    ];
    protected $appends = [
        'full_name'
    ];
    protected $casts = [
        'type' => 'array', // Cast the type attribute to an array
    ];

    public function roles(): MorphToMany
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_permissions', 'permission_id', 'model_id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->type . ' ' . $this->name;
    }

    public function hasType(string $type): bool
    {
        return in_array($type, $this->type);
    }

    public function addType(string $type): void
    {
        $types = $this->type;
        if (!in_array($type, $types)) {
            $types[] = $type;
            $this->type = $types;
            $this->save();
        }
    }

    public function removeType(string $type): void
    {
        $types = $this->type;
        if (($key = array_search($type, $types)) !== false) {
            unset($types[$key]);
            $this->type = array_values($types);
            $this->save();
        }
    }

    public static function findByName(string $name, $guardName = null): Permission
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        return static::where('name', $name)->where('guard_name', $guardName)->firstOrFail();
    }

    public static function findById(int $id, $guardName = null): Permission
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        return static::where('id', $id)->where('guard_name', $guardName)->firstOrFail();
    }

    public static function findOrCreate(string $name, $guardName = null): Permission
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        return static::firstOrCreate(['name' => $name, 'guard_name' => $guardName]);
    }
}
