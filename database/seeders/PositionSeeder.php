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
            // Board Positions
            [
                'name' => 'Chairperson',
                'description' => 'Leads the board and ensures effective governance of the organization.',
                'model' => 'board',
                'icon' => 'fa-users'
            ],
            [
                'name' => 'Vice-Chairperson',
                'description' => 'Assists the Chairperson and takes on their responsibilities when absent.',
                'model' => 'board',
                'icon' => 'fa-user-friends'
            ],
            [
                'name' => 'Secretary',
                'description' => 'Maintains meeting minutes and official records of the organization.',
                'model' => 'board',
                'icon' => 'fa-user-circle'
            ],
            [
                'name' => 'Treasurer',
                'description' => 'Oversees the financial management and health of the organization.',
                'model' => 'board',
                'icon' => 'fa-user-tie'
            ],
            [
                'name' => 'Board Member',
                'description' => 'Participates in decision-making and governance of the organization.',
                'model' => 'board',
                'icon' => 'fa-chess-rook'
            ],
            [
                'name' => 'Cabinet Secretary Rep',
                'description' => 'Represents the National Treasury and Economic Planning on the board.',
                'model' => 'board',
                'icon' => 'fa-landmark'
            ],
            [
                'name' => 'Chief Executive Officer (CEO)',
                'description' => 'Manages the day-to-day operations of the organization and reports to the board.',
                'model' => 'board',
                'icon' => 'fa-user-cog'
            ],

            // Committee Positions
            [
                'name' => 'Committee Chair',
                'description' => 'Leads a specific committee within the board.',
                'model' => 'committee',
                'icon' => 'fa-chair'
            ],
            [
                'name' => 'Committee Vice-Chair',
                'description' => 'Assists the Committee Chair and takes on their responsibilities when absent.',
                'model' => 'committee',
                'icon' => 'fa-user-friends'
            ],
            [
                'name' => 'Committee Secretary',
                'description' => 'Maintains meeting minutes and records for the committee.',
                'model' => 'committee',
                'icon' => 'fa-user-circle'
            ],
            [
                'name' => 'Committee Member',
                'description' => 'Participates in the committee’s activities and decision-making.',
                'model' => 'committee',
                'icon' => 'fa-chess-rook'
            ],
            [
                'name' => 'Advisory Member',
                'description' => 'Provides expert advice and support to the committee.',
                'model' => 'committee',
                'icon' => 'fa-comments'
            ],
            [
                'name' => 'Committee Treasurer',
                'description' => 'Oversees financial matters for the committee.',
                'model' => 'committee',
                'icon' => 'fa-user-tie'
            ],

            // Meeting Positions
            [
                'name' => 'Meeting Chairperson',
                'description' => 'Leads and facilitates the meeting, ensuring that the agenda is followed.',
                'model' => 'meeting',
                'icon' => 'fa-gavel'
            ],
            [
                'name' => 'Meeting Secretary',
                'description' => 'Takes notes during the meeting, documenting discussions and decisions.',
                'model' => 'meeting',
                'icon' => 'fa-pencil-alt'
            ],
            [
                'name' => 'Meeting Treasurer',
                'description' => 'Oversees financial discussions and reports on the financial status during the meeting.',
                'model' => 'meeting',
                'icon' => 'fa-wallet'
            ],
            [
                'name' => 'Board Members',
                'description' => 'Board members who participate in the meeting.',
                'model' => 'meeting',
                'icon' => 'fa-users'
            ],
            [
                'name' => 'Committee Members',
                'description' => 'Committee members who participate in the meeting.',
                'model' => 'meeting',
                'icon' => 'fa-chair'
            ],
            [
                'name' => 'Presenter',
                'description' => 'Designated to present information, reports, or proposals during the meeting.',
                'model' => 'meeting',
                'icon' => 'fa-chalkboard-teacher'
            ],
            [
                'name' => 'Meeting Member',
                'description' => 'General attendees who contribute to the discussions.',
                'model' => 'meeting',
                'icon' => 'fa-user-friends'
            ],
            [
                'name' => 'Guest Speaker',
                'description' => 'External individual invited to provide expertise or insights.',
                'model' => 'meeting',
                'icon' => 'fa-microphone'
            ],
            [
                'name' => 'Observer',
                'description' => 'Attends the meeting to observe the proceedings without direct participation.',
                'model' => 'meeting',
                'icon' => 'fa-eye'
            ],
            [
                'name' => 'Timekeeper',
                'description' => 'Keeps track of the time and ensures the meeting stays on schedule.',
                'model' => 'meeting',
                'icon' => 'fa-clock'
            ],
            [
                'name' => 'Facilitator',
                'description' => 'Manages the flow of the meeting, encouraging participation and keeping discussions focused.',
                'model' => 'meeting',
                'icon' => 'fa-hands-helping'
            ],
            [
                'name' => 'Vice-Chairperson',
                'description' => 'Assists the chairperson and may take over their responsibilities if they are absent.',
                'model' => 'meeting',
                'icon' => 'fa-user-friends'
            ],
            [
                'name' => 'PS Ministry Rep',
                'description' => 'Represents the PS Ministry of Water, Sanitation, and Irrigation during the meeting.',
                'model' => 'meeting',
                'icon' => 'fa-water'
            ],
            [
                'name' => 'Inspector General Rep',
                'description' => 'Represents the Inspector General of State Corporations during the meeting.',
                'model' => 'meeting',
                'icon' => 'fa-building'
            ],
            [
                'name' => 'Principal Legal Officer',
                'description' => 'Takes notes and provides legal insights during the meeting.',
                'model' => 'meeting',
                'icon' => 'fa-gavel'
            ],
            [
                'name' => 'Manager Legal Services',
                'description' => 'Takes notes and manages legal services during the meeting.',
                'model' => 'meeting',
                'icon' => 'fa-briefcase'
            ]
        ];

        foreach ($positions as $position) {
            Position::firstOrCreate([
                'name'         => $position['name'],
                'description'  => $position['description'],
                'model'        => $position['model'],
                'icon'         => $position['icon'],
                'active'       => StatusEnum::Active->value,
            ]);
        }
    }
}