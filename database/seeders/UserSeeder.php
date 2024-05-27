<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Users\Profile;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'first' => 'Super',
                'last'  => 'Admin',
                'email' => 'superadmin@gmail.com',
                'phone' => '0700000009',
                'idpassportnumber' => '30000000',
                'type' => User::$type_system,
                'role' => 'Super Admin',
                'status' => '1',
                'password' => '123456789',
            ],
            [
                'first' => 'Admin',
                'last' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone' => '0700000001',
                'idpassportnumber' => '300000001',
                'type' => User::$type_admin,
                'role' => 'Admin',
                'status' => '1',
                'password' => '123456789',
            ],
            [
                'first' => 'CEO',
                'last' => 'CEO',
                'email' => 'ceo@gmail.com',
                'phone' => '0700000002',
                'idpassportnumber' => '30000002',
                'type' => User::$type_ceo,
                'role' => 'CEO',
                'status' => '1',
                'password' => '123456789',
            ],
            [
                'first' => 'Company',
                'last' => 'Chairman',
                'email' => 'companychairman@gmail.com',
                'phone' => '0700000003',
                'idpassportnumber' => '30000003',
                'type' => User::$type_company_chairman,
                'role' => 'Company Chairman',
                'status' => '1',
                'password' => '123456789',
            ],
            [
                'first' => 'Company',
                'last' => 'Secretary',
                'email' => 'companysecretary@gmail.com',
                'phone' => '0700000004',
                'idpassportnumber' => '300000004',
                'type' => User::$type_company_secretary,
                'role' => 'Company Secretary',
                'status' => '1',
                'password' => '123456789',
            ],
            [
                'first' => 'Chairperson',
                'last' => 'Chairperson',
                'email' => 'chairperson@gmail.com',
                'phone' => '0700000005',
                'idpassportnumber' => '30000005',
                'type' => User::$type_chairperson,
                'role' => 'Chairperson',
                'status' => '1',
                'password' => '123456789',
            ],
            [
                'first' => 'Secretary',
                'last' => 'Secretary',
                'email' => 'secretary@gmail.com',
                'phone' => '0700000006',
                'idpassportnumber' => '30000006',
                'type' => User::$type_secretary,
                'role' => 'Secretary',
                'status' => '1',
                'password' => '123456789',
            ],
            [
                'first' => 'Guest',
                'last' => 'Guest',
                'email' => 'guest@gmail.com',
                'phone' => '0700000007',
                'idpassportnumber' => '30000007',
                'type' => User::$type_guest,
                'role' => 'Guest',
                'status' => '1',
                'password' => '123456789',
            ],
            [
                'first' => 'Observer',
                'last' => 'Observer',
                'email' => 'observer@gmail.com',
                'phone' => '0700000008',
                'idpassportnumber' => '30000008',
                'type' => User::$type_default,
                'role' => 'Observer',
                'status' => '1',
                'password' => '123456789',
            ],
        ];
        foreach ($data as $user) {
            $newuser = User::withoutApproval()->firstOrCreate([
                'first' => $user['first'],
                'last' => $user['last'],
                'email' => $user['email'],
                'role' => $user['role'],
                'type' => $user['type'],
                'status' => $user['status'],
                'password' => $user['password'],
                'email_verified_at' => now('Africa/Nairobi'),
            ]);
            $profile = Profile::firstOrCreate([
                'user_id'            => $newuser->id,
                'phone'              => $user['phone'],
                'idpassportnumber'   => $user['idpassportnumber'],
                'title'              => $user['role'],
            ]);
        }
        //self update
        // $table->string('avatar')->nullable();
        // $table->string('ethnicity')->nullable();
        // $table->string('phone')->unique()->nullable();
        // $table->string('idpassportnumber')->unique()->nullable();
        // $table->string('gender_id')->nullable();
        // // address
        // $table->string('address')->nullable();
        // $table->string('home_county_id')->nullable();
        // $table->string('residence_county_id')->nullable();
        // $table->string('city')->nullable();
        // $table->string('state')->nullable();
        // $table->string('nationality')->nullable();
        // // self documents
        // $table->longText('about')->nullable();
        // $table->string('kra_pin')->nullable();
        // $table->string('member_cv')->nullable();
        // // official
        // $table->string('establishment')->nullable();
        // $table->string('title')->nullable();
        // $table->string('appointing_authority')->nullable();
        // $table->string('DOA')->nullable();
        // $table->string('appointment_letter')->nullable();
        // $table->string('appointment_end_date')->nullable();
        // $table->string('serving_term')->nullable();
        // $table->string('current_period')->nullable();
        // $table->string('user_id');
    }
}
