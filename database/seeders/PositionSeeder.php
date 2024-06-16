<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use Illuminate\Database\Seeder;
use App\Models\Module\Member\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'name' => 'Chairperson',
                'description' => 'Leads the board and ensures effective governance of the organization.',
            ],
            [
                'name' => 'Vice-Chairperson',
                'description' => 'Assists the Chairperson and takes on their responsibilities when absent.',
            ],
            [
                'name' => 'Secretary',
                'description' => 'Maintains meeting minutes and official records of the organization.',
            ],
            [
                'name' => 'Treasurer',
                'description' => 'Oversees the financial management and health of the organization.',
            ],
            [
                'name' => 'Board Member',
                'description' => 'Participates in decision-making and governance of the organization.',
            ],
            [
                'name' => 'Executive Director',
                'description' => 'Manages the day-to-day operations of the organization.',
            ],
            [
                'name' => 'Committee Chair',
                'description' => 'Leads a specific committee within the board.',
            ],
            [
                'name' => 'Advisory Board Member',
                'description' => 'Provides expert advice and support to the board.',
            ],
            [
                'name' => 'Member-at-Large',
                'description' => 'Represents the general membership on the board.',
            ],
            [
                'name' => 'Emeritus Board Member',
                'description' => 'A former board member who continues to provide valuable advice.',
            ],
        ];

        foreach ($positions as $position) {
            Position::firstOrCreate([
                'name'         => $position['name'],
                'description'  => $position['description'],
                'active'       => StatusEnum::Active->value,
            ]);
        }
    }
}