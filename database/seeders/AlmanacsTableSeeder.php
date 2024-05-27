<?php

namespace Database\Seeders;

use App\Enums\ApprovalEnum;
use App\Models\System\Almanac;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class AlmanacsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        Almanac::firstOrCreate([
            'type' => 'sample',  // Static value as required
            'purpose' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            'start' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now')->format('Y-m-d\TH:i:s\.000\Z'),
            'end' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 year')->format('Y-m-d\TH:i:s\.000\Z'),
            'budget' => $faker->numberBetween(1000, 1000000),
            'budget' => $faker->numberBetween(1000, 1000000),
            'status' => $faker->randomElement([ApprovalEnum::Approved->value, ApprovalEnum::Default->value]),
        ]);
    }
}