<?php

namespace App\Repository;

use stdClass;
use App\Models\Config\Setting;
use Illuminate\Http\UploadedFile;
use App\Repository\BaseRepository;
use App\Http\Resources\SettingResource;
use App\Repository\Actions\ImageAction;
use App\Providers\MailConfigServiceProvider;
use App\Repository\Contracts\SettingInterface;

class SettingRepository extends BaseRepository implements SettingInterface
{
    // Implement the methods
    public function getSetting(): SettingResource
    {
        $setting = Setting::first();

        return SettingResource::make($setting)->format(SettingResource::SETTINGS);
    }
    public function getMailTypes(): SettingResource
    {
        $setting = Setting::first();
        return SettingResource::make($setting)->format(SettingResource::MAILTYPES);
    }


    // Implement the methods
    public function update(Setting|string $setting, array $payload): SettingResource
    {
        if (!($setting instanceof Setting)) {
            $setting = Setting::findOrFail($setting);
        }
        $peviouslogoName = $setting->logo;
        $pevioustextlogoName = $setting->textlogo;
        $peviousisologoName = $setting->isologo;

        $logo = $this->logoManage($payload, $peviouslogoName);
        $textlogo = $this->textlogoManage($payload, $pevioustextlogoName);
        $isologo = $this->isologoManage($payload, $peviousisologoName);

        $setting->logo = $logo;
        $setting->textlogo = $textlogo;
        $setting->name = $payload['name'];
        $setting->about = $payload['about'];
        $setting->website = $payload['website'];
        $setting->iso = $payload['iso'];
        $setting->isologo = $isologo;
        $setting->address = $payload['address'];
        $setting->county = $payload['county'];
        $setting->city = $payload['city'];
        $setting->state = $payload['state'];
        $setting->phone1 = $payload['phone1'];
        $setting->phone2 = $payload['phone2'];
        // $setting->mailer = $payload['mailer'];
        // $setting->mailhost = $payload['mailhost'];
        // $setting->mailport = $payload['mailport'];
        // $setting->mailusername = $payload['mailusername'];
        // $setting->mailpassword = $payload['mailpassword'];
        // $setting->mailencryption = $payload['mailencryption'];
        // $setting->mailfromaddress = $payload['mailfromaddress'];
        // $setting->mailfromname = $payload['mailfromname'];
        $setting->pspdkitlicencekey = $payload['pspdkitlicencekey'];
        if (isset($payload['mailtype'])) {
            // $encoded = json_encode($payload['mailtype']);
            // $decoded = json_decode($encoded);
            // dd($payload['mailtype'], $encoded, $decoded);
            $setting->mailtype = $payload['mailtype'];
        }

        $setting->save();
        // Call the configureMailSettings method to apply the new settings
        MailConfigServiceProvider::configureMailSettings();
        // dd(config('mail'));
        return SettingResource::make($setting)->format(SettingResource::SETTINGS);
    }
    public function logoManage($payload, $peviousfileName = null)
    {
        $logo = $payload['logo'] ?? null;
        if ($logo instanceof UploadedFile && $logo->isValid()) {
            $file = $payload['logo'];
            $folderLocation = '/images/logo/';
            // Create a new stdClass object
            $manupulation = new stdClass();
            // Set the properties
            $manupulation->targetHeight = 250;
            $manupulation->aspectRatio = 250 / 167;
            $manupulation->targetWidth = $manupulation->targetHeight * $manupulation->aspectRatio;

            $logoName = make(ImageAction::class)
                ->executeLogo($file, $folderLocation, $manupulation, $peviousfileName);
        } else {

            $logoName = $peviousfileName;
        }
        return $logoName;
    }
    public function textlogoManage($payload, $peviousfileName = null)
    {
        $textlogo = $payload['textlogo'] ?? null;
        if ($textlogo instanceof UploadedFile && $textlogo->isValid()) {
            $file = $payload['textlogo'];
            $folderLocation = '/images/textlogo/';
            // Create a new stdClass object
            $manupulation = new stdClass();
            // Set the properties
            $manupulation->targetHeight = 250;
            $manupulation->aspectRatio = 250 / 167;
            $manupulation->targetWidth = $manupulation->targetHeight * $manupulation->aspectRatio;

            $textlogoName = make(ImageAction::class)
                ->executeTextlogo($file, $folderLocation, $manupulation, $peviousfileName);
        } else {

            $textlogoName = $peviousfileName;
        }
        return $textlogoName;
    }
    public function isologoManage($payload, $peviousfileName = null)
    {
        $isologo = $payload['isologo'] ?? null;
        if ($isologo instanceof UploadedFile && $isologo->isValid()) {
            $file = $payload['isologo'];
            $folderLocation = '/images/iso/';
            // Create a new stdClass object
            $manupulation = new stdClass();
            // Set the properties
            $manupulation->targetHeight = 250;
            $manupulation->aspectRatio = 250 / 167;
            $manupulation->targetWidth = $manupulation->targetHeight * $manupulation->aspectRatio;

            $isologoName = make(ImageAction::class)
                ->executeIsologo($file, $folderLocation, $manupulation, $peviousfileName);
        } else {

            $isologoName = $peviousfileName;
        }
        return $isologoName;
    }
}
