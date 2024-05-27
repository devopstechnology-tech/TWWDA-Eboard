<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\StatusEnum;
use Sourcetoad\EnhancedResources\Formatting\Attributes\Format;
use Sourcetoad\EnhancedResources\Formatting\Attributes\IsDefault;

class SettingResource extends BaseResource
{
    public const SETTINGS = 'settings';
    public const MAILTYPES = 'mailtypes';
    #[Format, IsDefault]
    public function base(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'logo' => $this->resource->logo,
            'textlogo' => $this->resource->textlogo,
            'name' => $this->resource->name,
            'about' => $this->resource->about,
            'website' => $this->resource->website,
            'iso' => $this->resource->iso,
            'isologo' => $this->resource->isologo,
            'address' => $this->resource->address,
            'county' => $this->resource->county,
            'city' => $this->resource->city,
            'state' => $this->resource->state,
            'phone1' => $this->resource->phone1,
            'phone2' => $this->resource->phone2,
            'pspdkitlicencekey' => $this->resource->pspdkitlicencekey,
            'mailtype' => json_decode($this->resource->mailtype, true),  // Include mailtype directly from the model
            'mailtypes' => json_decode($this->resource->mailtypes, true),  // Include mailtype directly from the model
        ];
    }
    #[Format(self::SETTINGS)]
    public function settings(): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'logo' => $this->resource->logo,
            'textlogo' => $this->resource->textlogo,
            'name' => $this->resource->name,
            'about' => $this->resource->about,
            'website' => $this->resource->website,
            'iso' => $this->resource->iso,
            'isologo' => $this->resource->isologo,
            'address' => $this->resource->address,
            'county' => $this->resource->county,
            'city' => $this->resource->city,
            'state' => $this->resource->state,
            'phone1' => $this->resource->phone1,
            'phone2' => $this->resource->phone2,
            'pspdkitlicencekey' => $this->resource->pspdkitlicencekey,
            'mailtype' => json_decode($this->resource->mailtype, true),
        ];
    }

    #[Format('short')]
    public function short(): array
    {
        return [
            // Define short resource fields if necessary
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }
    #[Format(self::MAILTYPES)]
    public function mailtypesFormat(): array
    {
        // Decoding the mailtypes JSON string to an array
        $mailTypes = json_decode($this->resource->mailtypes, true);

        // Transform each mailType to a more structured format
        return array_map(function ($mailType) {
            return [
                'id' => $mailType['id'],
                'name' => $mailType['name'],
                'active' => $mailType['active'],
                'values' => $mailType['values'],
                // 'isActive' => $mailType['active'] === StatusEnum::Active->value,
                // 'configuration' => array_map(function ($config) {
                //     return [
                //         'field' => $config['nameField'],
                //         'placeholder' => $config['namePlaceholder'],
                //         'value' => $config['valueName'],
                //     ];
                // }, $mailType['values']),
            ];
        }, $mailTypes);
    }
}
