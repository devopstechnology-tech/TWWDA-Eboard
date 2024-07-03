<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolePermSeeder extends Seeder
{
    protected array $allPermissions = [];

    public function __construct()
    {
        $path = app_path() . '/Permissions';
        $this->allPermissions = $this->getAllPermissions($path);
    }

    public function getAllPermissions($path): array
    {
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') {
                continue;
            }
            $filename = $path . '/' . $result;
            if (is_dir($filename)) {
                $out = array_merge($out, $this->getAllPermissions($filename));
            } else {
                $class = substr('App\\Permissions\\' . $result, 0, -4);
                foreach ((new $class())::allPermissions() as $permission) {
                    $out[] = [
                        ...$permission,
                        'class' => explode('.', $result)[0],
                        'action' => ucfirst(explode(' ', $permission['name'])[0]),
                    ];
                }
            }
        }
        return $out;
    }

    public function run(): void
    {
        DB::transaction(function () {
            $this->createRoles();
            $this->createPermissions();
            $this->givePermissionsToRoles();
            $this->giveRolesToUsers();
        });
    }

    public function createRoles(): void
    {
        $roles = [
            'System', //superadmin
            'Admin',
            'CEO',
            'Company Chairman',
            'Company Secretary',
            'Chairperson',
            'Secretary',
            'Member',
            'Guest',
            'Observer',
        ];

        foreach ($roles as $role) {
            // Define the role type based on the role name
            $type = match ($role) {
                'System' => Role::$type_system,
                'Admin' => Role::$type_admin,
                'CEO' => Role::$type_ceo,
                'Company Chairman' => Role::$type_company_chairman,
                'Company Secretary' => Role::$type_company_secretary,
                'Chairperson' => Role::$type_chairperson,
                'Secretary' => Role::$type_secretary,
                'Member' => Role::$type_member,
                'Guest' => Role::$type_guest,
                default => Role::$type_default,
            };

            $roleModel = Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
                'type' => $type,
            ]);

            // Debugging role creation
            echo "Role created: " . $roleModel->id . " - " . $roleModel->name . PHP_EOL;
        }
    }

    public function createPermissions(): void
    {
        collect($this->allPermissions)->each(function ($permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'guard_name' => 'web',
                'type' => json_encode($permission['type']),
                'class' => $permission['class'],
                'action' => $permission['action'],
                'description' => $permission['description'],
            ]);
        });
    }

    public function givePermissionsToRoles(): void
    {
        $roles = Role::all();
        $permissions = Permission::all();

        foreach ($roles as $role) {
            $roleType = $role->type;

            foreach ($permissions as $permission) {
                $types = json_decode($permission->type, true);

                if (in_array($roleType, $types)) {
                    // Debugging role and permission assignment
                    $role->givePermissionTo($permission);
                }
            }
        }
    }

    public function giveRolesToUsers(): void
    {
        $this->assignRoles(User::$type_default, Role::$type_default);
        $this->assignRoles(User::$type_guest, Role::$type_guest);
        $this->assignRoles(User::$type_member, Role::$type_member);
        $this->assignRoles(User::$type_secretary, Role::$type_secretary);
        $this->assignRoles(User::$type_chairperson, Role::$type_chairperson);
        $this->assignRoles(User::$type_company_secretary, Role::$type_company_secretary);
        $this->assignRoles(User::$type_company_chairman, Role::$type_company_chairman);
        $this->assignRoles(User::$type_ceo, Role::$type_ceo);
        $this->assignRoles(User::$type_admin, Role::$type_admin);
        $this->assignRoles(User::$type_system, Role::$type_system);
    }

    protected function assignRoles(string $userType, string $roleType): void
    {
        $users = User::where('type', $userType)->get();
        $roles = Role::where('type', $roleType)->pluck('id');

        foreach ($users as $user) {
            $user->roles()->syncWithoutDetaching($roles);
        }
    }
}
