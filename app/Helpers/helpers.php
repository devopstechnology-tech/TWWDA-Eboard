<?php

declare(strict_types=1);

use App\Jobs\EmailJob;
use App\Jobs\SMSJob;
use App\Notifications\SlackMessenger;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Jenssegers\Agent\Agent;
use Monolog\Handler\StreamHandler;

function formatPhoneNumber(string $phone): string
{
    return '254' . substr(str_replace([' ', '-', '_', '', '/'], '', $phone), -9);
}

function formatIdNumber(string $id): string
{
    return str_replace(['-', '_', '', '/', ' ', '$', '@'], '', $id);
}

function formatEmail(string $email): string
{
    return preg_replace('/\s+/', '', strtolower($email));
}

function make(string $class, array $params = []): object
{
    return resolve($class, $params);
}

function logDataToFile($data, $userFile, $descriptor = 'fileLogs'): void
{
    $log = new Logger($descriptor);
    try {
        $log->pushHandler(new StreamHandler(storage_path($userFile), LOG_INFO, false));
    } catch (Exception $e) {
    }
    $log->info(json_encode($data));
}

function generateLoginLog($user): void
{
    $agent = new Agent();
    $user->loginLogs()->create([
        'ip_address' => request()->ip(),
        'device' => $agent->device(),
        'browser' => $agent->browser(),
        'os' => $agent->platform(),
        'version' => $agent->version($agent->browser()),
        'isRobot' => $agent->isRobot(),
        'languages' => implode(',', $agent->languages()),
        'login_loggable_type' => (new $user())->getMorphClass(),
        'login_loggable_id' => $user->id,
    ]);
}

function customLog($class, $data, $activity = 'viewed'): void
{
    $array = explode('\\', $class);
    $className = end($array);
    activity($className)
        ->event('viewed')
        ->performedOn(new $class())
        ->causedBy(Auth::user())
        ->withProperties(['attributes' => $data])
        ->log($className . ' ' . $activity);
}

function sendSms($phone, $message): void
{
    dispatch(new SMSJob($message, $phone));
}

function sendSlack($message, $from): void
{
    // Notification::route('slack', env('SLACK_HOOK1', 'https://hooks.slack.com/services/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'))->notify(new SlackMessenger($message, $from));
}

function sendSlackNotify($message, $from, $channel, $mainTitle = null, $title = 'New Notification'): void
{
    // Notification::route('slack', 'https://hooks.slack.com/services/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')
    // ->notify(new SlackMessenger($message, $from, $channel, $mainTitle, $title));
}

function sendMail($email, $subject, $message): void
{
    dispatch(new EmailJob($email, $subject, $message));
}

function generateLowerCaseRandomString($length = 4): string
{
    $characters = '1234567890abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function generateRandomIntString($length = 4): string
{
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function storeFile($request, $keyName, $fileName = 'randomFile', $path = 'storage/uploads'): ?string
{
    $upload_path = public_path($path);
    File::isDirectory($upload_path) or File::makeDirectory($path, 0777, true, true);
    if ($request->hasFile($keyName)) {
        $file = $request->file($keyName);
        $passportName = $fileName . '.' . $file->getClientOriginalExtension();
        $file->move($upload_path, $passportName);

        return url($path, $passportName);
    }

    return null;
}

function generateRandomString($length = 4): string
{
    $characters = '23456789ABCDEFGHJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function incMulti($string, $val = 1)
{
    if ($val == 1) {
        return addUp($string);
    } elseif ($val > 1) {
        for ($i = 0; $i < $val; $i++) {
            $string = addUp($string);
        }

        return $string;
    } else {
        return 0;
    }
}

function addUp($str): string
{
    $last = substr($str, -1);
    $hold = substr($str, 0, -1);
    switch ($last) {
        case '9':
        case '':
            $upNext = 'A';
            break;
        case 'Z':
            $upNext = '0';
            $reUse = addUp($hold);
            $hold = $reUse;
            break;
        default:
            $upNext = ++$last;
            break;
    }

    return $hold . $upNext;
}

function deleteOldImage($folderLocation, $path, $image): bool
{
    $destinationPath = $folderLocation . $path . '/';

    return File::delete($destinationPath . $image);
}

function convertToWords($num): array|string
{
    $num = (string) ((int) $num);

    if ((int) ($num) && ctype_digit($num)) {
        $words = [];

        $num = str_replace([',', ' '], '', trim($num));

        $list1 = [
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
            'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
            'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        ];

        $list2 = [
            '', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
            'seventy', 'eighty', 'ninety', 'hundred'
        ];

        $list3 = [
            '', 'thousand', 'million', 'billion', 'trillion',
            'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion',
            'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion',
            'octodecillion', 'novemdecillion', 'vigintillion'
        ];

        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);

        foreach ($num_levels as $num_part) {
            $levels--;
            $hundreds = (int) ($num_part / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
            $tens = (int) ($num_part % 100);
            $singles = '';

            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int) ($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_part % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
        }
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }

        $words = implode(', ', $words);

        $words = trim(str_replace(' ,', ',', ucwords($words)), ', ');
        if ($commas) {
            $words = str_replace(',', ' and', $words);
        }
    } elseif (!((int) $num)) {
        $words = 'Zero';
    } else {
        $words = '';
    }

    return $words;
}
