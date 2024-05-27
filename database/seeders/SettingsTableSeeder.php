<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use App\Models\Config\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $about = 'We are Tana Water Works Development Agency (TWWDA), established on April 26, 2019, under the Water Act 2016, serving Kirinyaga, Nyeri, Meru, Embu, and Tharaka Nithi counties. Overseeing 17,189.7 km², we manage six major water projects funded by the Government of Kenya and the African Development Bank, enhancing water and sanitation services for nearly 1.4 million people.';
        $website = 'www.tanawwda.go.ke';

        $mailTypes = [
            [
                'id' => Str::uuid()->toString(),
                'name' => 'smtp',
                'active' => StatusEnum::Active->value,
                'values' => [
                    [
                        'nameField' => 'MAIL_HOST',
                        'namePlaceholder' => 'SMTP Server Address',
                        'valueName' => 'helpdesk.kinyanjuitechnical.ac.ke',
                    ],
                    [
                        'nameField' => 'MAIL_PORT',
                        'namePlaceholder' => 'SMTP Port (usually 587)',
                        'valueName' => '465',
                    ],
                    [
                        'nameField' => 'MAIL_USERNAME',
                        'namePlaceholder' => 'The SMTP Username',
                        'valueName' => 'support@helpdesk.kinyanjuitechnical.ac.ke',
                    ],
                    [
                        'nameField' => 'MAIL_PASSWORD',
                        'namePlaceholder' => 'The SMTP Password',
                        'valueName' => 'bzF~(v=D]Ho*',
                    ],
                    [
                        'nameField' => 'MAIL_FROM_NAME',
                        'namePlaceholder' => 'The SMTP Mail From Name',
                        'valueName' => 'Eboard Management System',
                    ],
                    [
                        'nameField' => 'MAIL_FROM_ADDRESS',
                        'namePlaceholder' => 'Your SMTP Mail From Address',
                        'valueName' => 'noreply@helpdesk.kinyanjuitechnical.ac.ke',
                    ],
                    [
                        'nameField' => 'MAIL_ENCRYPTION',
                        'namePlaceholder' => 'Encryption (tls or ssl) STARTTLS',
                        'valueName' => 'STARTTLS',
                    ],
                ],
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'mailgun',
                'active' => StatusEnum::Inactive->value,
                'values' => [
                    [
                        'nameField' => 'MAILGUN_DOMAIN',
                        'namePlaceholder' => 'Your Mailgun Domain',
                        'valueName' => '',
                    ],
                    [
                        'nameField' => 'MAILGUN_SECRET',
                        'namePlaceholder' => 'Your Mailgun API Key',
                        'valueName' => '',
                    ],
                    [
                        'nameField' => 'MAIL_FROM_NAME',
                        'namePlaceholder' => 'The SMTP Mail From Name',
                        'valueName' => 'Eboard Management System',
                    ],
                    [
                        'nameField' => 'MAIL_FROM_ADDRESS',
                        'namePlaceholder' => 'Your SMTP Mail From Address',
                        'valueName' => 'noreply@helpdesk.kinyanjuitechnical.ac.ke',
                    ],
                ],
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'ses',
                'active' => StatusEnum::Inactive->value,
                'values' => [
                    [
                        'nameField' => 'SES_KEY',
                        'namePlaceholder' => 'Your AWS SES Key',
                        'valueName' => '',
                    ],
                    [
                        'nameField' => 'SES_SECRET',
                        'namePlaceholder' => 'Your AWS SES Secret',
                        'valueName' => '',
                    ],
                    [
                        'nameField' => 'SES_REGION',
                        'namePlaceholder' => 'AWS Region (e.g., us-east-1)',
                        'valueName' => '',
                    ],
                    [
                        'nameField' => 'MAIL_FROM_NAME',
                        'namePlaceholder' => 'The SMTP Mail From Name',
                        'valueName' => 'Eboard Management System',
                    ],
                    [
                        'nameField' => 'MAIL_FROM_ADDRESS',
                        'namePlaceholder' => 'Your SMTP Mail From Address',
                        'valueName' => 'noreply@helpdesk.kinyanjuitechnical.ac.ke',
                    ],
                ],
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'postmark',
                'active' => StatusEnum::Inactive->value,
                'values' => [
                    [
                        'nameField' => 'POSTMARK_TOKEN',
                        'namePlaceholder' => 'Your Postmark Server Token',
                        'valueName' => '',
                    ],
                    [
                        'nameField' => 'MAIL_FROM_NAME',
                        'namePlaceholder' => 'The SMTP Mail From Name',
                        'valueName' => 'Eboard Management System',
                    ],
                    [
                        'nameField' => 'MAIL_FROM_ADDRESS',
                        'namePlaceholder' => 'Your SMTP Mail From Address',
                        'valueName' => 'noreply@helpdesk.kinyanjuitechnical.ac.ke',
                    ],
                ],
            ],
        ];

        // Extract and store the active configuration
        $activeMailType = null;
        foreach ($mailTypes as &$mailType) {
            if ($mailType['active'] === StatusEnum::Active->value) {
                $activeMailType = $mailType;
                break;
            }
        }

        // Clear valueName in all configurations
        foreach ($mailTypes as &$mailType) {
            foreach ($mailType['values'] as &$value) {
                $value['valueName'] = '';  // Set valueName to empty
            }
        }

        // Restore the original valueName in the active configuration before storing
        // if ($activeMailType !== null) {
        //     foreach ($mailTypes as &$mailType) {
        //         if ($mailType['id'] === $activeMailType['id']) {
        //             $mailType = $activeMailType;
        //             break;
        //         }
        //     }
        // }

        Setting::firstOrCreate([
            'logo' => 'defaultlogo.png',
            'textlogo' => 'defaulttextlogo.png',
            'name' => 'Tana Water Works Development Agency',
            'about' => $about,
            'website' => $website,
            'iso' => 'ISO 9001:2015',
            'isologo' => 'defaultiso.png',
            'address' => 'MAJI HOUSE ALONG BADEN POWELL ROAD ,P.O. BOX, 1292 ∼ 10100.',
            'county' => 'Machakos',
            'city' => 'Nairobi',
            'state' => 'Kenya',
            'phone1' => '+254 724 259 891',
            'phone2' => '+254 61-2032282',
            'pspdkitlicencekey' => 'TH8Qp7q9KPBLFnAItdIZ3lz9ihiqZxTUUuPhZhug2mGh7YkhmCqgMgi8gICcWSCNeCbti4-ZqzplTuKzRcYCBiPNFB6Ey_tnSVxl9tCDGkE5ZNrTMK8yXZ0nF8ykUnCrb7oVefIUwnxFdY51cDRAo2eXH2bvmGRyGbq66UWlepqciwqoqauW9oznmiUdWtna4dXMn6OLamI4g9d9',
            'mailtype' => json_encode($activeMailType),   // Store the active mail configuration
            'mailtypes' => json_encode($mailTypes),      // Store the full list with the valueNames emptied
        ]);
    }
}
