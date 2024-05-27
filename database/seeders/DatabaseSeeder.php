<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\UserRolePermSeeder;
use Database\Seeders\AlmanacsTableSeeder;
use Database\Seeders\SettingsTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SettingsTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserRolePermSeeder::class);
        $this->call(AlmanacsTableSeeder::class);
    }
}
