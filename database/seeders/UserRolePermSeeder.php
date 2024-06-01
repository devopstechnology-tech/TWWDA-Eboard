<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserRolePermSeeder extends Seeder
{
    protected array $allPermissions = [];

    public function __construct()
    {
        $path = app_path() . '/Permissions';
        $paths = $this->getAllPermissions($path);
        $this->allPermissions = $paths;
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
                foreach (range(1, count((new $class())::allPermissions())) as $index) {
                    $out[] = [
                        ...(new $class())::allPermissions()[$index - 1],
                        'class' => explode('.', $result)[0],
                        'action' => ucfirst(explode(' ', (new $class())::allPermissions()[$index - 1]['name'])[0]),
                    ];
                }
            }
        }

        return $out;
    }

    public function run(): void
    {
        $this->createRoles();
        $this->createPermissions();
        $this->givePermissionsToRoles();
        $this->giveRolesToUsers();
    }

    public function createRoles(): void
    {
        $roles = [
            'System', //superadmi
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
        // foreach ($roles as $role) {
        //     Role::withoutApproval()->firstOrCreate([
        //         'name' => $role,
        //         'guard_name' => 'web',
        //         'type' => $role == 'System' ? Role::$type_system : ($role == 'Admin' ? Role::$type_admin :
        //             Role::$type_default),
        //     ]);
        // }
        foreach ($roles as $role) {
            // Define the role type based on the role name
            if ($role === 'System') {
                $type = Role::$type_system; // Assign system type for System role
            } elseif ($role === 'Admin') {
                $type = Role::$type_admin; // Assign admin type for Admin role
            } elseif ($role === 'CEO') {
                $type = Role::$type_ceo;
            } elseif ($role === 'Company Chairman') {
                $type = Role::$type_company_chairman;
            } elseif ($role === 'Company Secretary') {
                $type = Role::$type_company_secretary;
            } elseif ($role === 'Chairperson') {
                $type = Role::$type_chairperson;
            } elseif ($role === 'Secretary') {
                $type = Role::$type_secretary;
            } elseif ($role === 'Member') {
                $type = Role::$type_member;
            } elseif ($role === 'Guest') {
                $type = Role::$type_guest;
            } elseif ($role === 'Observer') {
                $type = Role::$type_default; // Assign default type for other roles
            }

            // Create or update the role in the database without approval requirement
            Role::withoutApproval()->firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
                'type' => $type,
            ]);
        }
    }

    public function createPermissions(): void
    {
        collect($this->allPermissions)->each(function ($permission) {
            Permission::firstOrCreate([
                ...$permission,
                'guard_name' => 'web',
            ]);
        });
    }

    public function givePermissionsToRoles(): void
    {

        $systemPermissions           = Permission::where('type', Permission::$type_system)->pluck('id');
        $adminPermissions            = Permission::where('type', Permission::$type_admin)->pluck('id');
        $ceoPermissions              = Permission::where('type', Permission::$type_ceo)->pluck('id');
        $companychairmanPermissions  = Permission::where('type', Permission::$type_company_chairman)->pluck('id');
        $companysecretaryPermissions = Permission::where('type', Permission::$type_company_secretary)->pluck('id');
        $chairpersonPermissions      = Permission::where('type', Permission::$type_chairperson)->pluck('id');
        $secretaryPermissions        = Permission::where('type', Permission::$type_secretary)->pluck('id');
        $memberPermissions           = Permission::where('type', Permission::$type_member)->pluck('id');
        $guestPermissions            = Permission::where('type', Permission::$type_guest)->pluck('id');
        $defaultPermissions          = Permission::where('type', Permission::$type_default)->pluck('id');

        // Give Default Roles all default Permissions
        $defaultRoles = Role::where('type', Role::$type_default)->get();
        foreach ($defaultRoles as $role) {
            foreach ($defaultPermissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        // Give Guest Roles all guest Permissions
        $guestRoles = Role::where('type', Role::$type_guest)->get();
        foreach ($guestRoles as $role) {
            foreach ($guestPermissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
        // Give Member Roles all member Permissions
        $memberRoles = Role::where('type', Role::$type_member)->get();
        foreach ($memberRoles as $role) {
            foreach ($memberPermissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
        // Give Secretary Roles all secretary Permissions
        $secretaryRoles = Role::where('type', Role::$type_secretary)->get();
        foreach ($secretaryRoles as $role) {
            foreach ($secretaryPermissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        // Give Chairperson Roles all chairperson Permissions
        $chairpersonRoles = Role::where('type', Role::$type_chairperson)->get();
        foreach ($chairpersonRoles as $role) {
            foreach ($chairpersonPermissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        // Give Company_secretary Roles all company_secretary Permissions
        $companysecretaryRoles = Role::where('type', Role::$type_company_secretary)->get();
        foreach ($companysecretaryRoles as $role) {
            foreach ($companysecretaryPermissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
        // Give Company_chairman Roles all company_chairman Permissions
        $companychairmanRoles = Role::where('type', Role::$type_company_chairman)->get();
        foreach ($companychairmanRoles as $role) {
            foreach ($companychairmanPermissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        // Give Ceo Roles all ceo Permissions
        $ceoRoles = Role::where('type', Role::$type_ceo)->get();
        foreach ($ceoRoles as $role) {
            foreach ($ceoPermissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
        // Give Admin Roles all admin Permissions
        $adminRoles = Role::where('type', Role::$type_admin)->get();
        foreach ($adminRoles as $role) {
            foreach ($adminPermissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        // Give System Roles all system Permissions
        $systemRoles = Role::where('type', Role::$type_system)->get();
        foreach ($systemRoles as $role) {
            foreach ($systemPermissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
    }

    public function giveRolesToUsers(): void
    {
        // default observer
        $defaultUsers = User::where('type', User::$type_default)->get();
        $defaultRoles = Role::where('type', Role::$type_default)->pluck('id');
        foreach ($defaultUsers as $user) {
            $user->roles()->syncWithoutDetaching($defaultRoles);
        }
        // guest
        $guestUsers = User::where('type', User::$type_guest)->get();
        $guestRoles = Role::where('type', Role::$type_guest)->pluck('id');
        foreach ($guestUsers as $user) {
            $user->roles()->syncWithoutDetaching($guestRoles);
        }
        // member
        $memberUsers = User::where('type', User::$type_member)->get();
        $memberRoles = Role::where('type', Role::$type_member)->pluck('id');
        foreach ($memberUsers as $user) {
            $user->roles()->syncWithoutDetaching($memberRoles);
        }
        // secretary
        $secretaryUsers = User::where('type', User::$type_secretary)->get();
        $secretaryRoles = Role::where('type', Role::$type_secretary)->pluck('id');
        foreach ($secretaryUsers as $user) {
            $user->roles()->syncWithoutDetaching($secretaryRoles);
        }

        // chairperson
        $chairpersonUsers = User::where('type', User::$type_chairperson)->get();
        $chairpersonRoles = Role::where('type', Role::$type_chairperson)->pluck('id');
        foreach ($chairpersonUsers as $user) {
            $user->roles()->syncWithoutDetaching($chairpersonRoles);
        }

        // company_secretary
        $companysecretaryUsers = User::where('type', User::$type_company_secretary)->get();
        $companysecretaryRoles = Role::where('type', Role::$type_company_secretary)->pluck('id');
        foreach ($companysecretaryUsers as $user) {
            $user->roles()->syncWithoutDetaching($companysecretaryRoles);
        }
        // company_chairman
        $companychairmanUsers = User::where('type', User::$type_company_chairman)->get();
        $companychairmanRoles = Role::where('type', Role::$type_company_chairman)->pluck('id');
        foreach ($companychairmanUsers as $user) {
            $user->roles()->syncWithoutDetaching($companychairmanRoles);
        }
        // ceo
        $ceoUsers = User::where('type', User::$type_ceo)->get();
        $ceoRoles = Role::where('type', Role::$type_ceo)->pluck('id');
        foreach ($ceoUsers as $user) {
            $user->roles()->syncWithoutDetaching($ceoRoles);
        }
        // admin
        $adminUsers = User::where('type', User::$type_admin)->get();
        $adminRoles = Role::where('type', Role::$type_admin)->pluck('id');
        foreach ($adminUsers as $user) {
            $user->roles()->syncWithoutDetaching($adminRoles);
        }
        // system
        $systemUsers = User::where('type', User::$type_system)->get();
        $systemRoles = Role::where('type', Role::$type_system)->pluck('id');
        foreach ($systemUsers as $user) {
            $user->roles()->syncWithoutDetaching($systemRoles);
        }
    }
}
