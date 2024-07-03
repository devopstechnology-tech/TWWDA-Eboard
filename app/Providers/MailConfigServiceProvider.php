<?php

declare(strict_types=1);
// app/Providers/MailConfigServiceProvider.php

namespace App\Providers;

use App\Models\Config\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->configureMailSettings();
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Configure mail settings from the database.
     */
    public static function configureMailSettings()
    {
        if (Schema::hasTable('settings')) {
            $setting = Setting::first();
            if ($setting) {
                $mailConfig = json_decode($setting->mailtype, true);
                if ($mailConfig) {
                    $values = collect($mailConfig['values'])->pluck('valueName', 'nameField')->toArray();
                    Config::set([
                        'mail.default' => $mailConfig['name'],
                        'mail.mailers.smtp.host' => $values['MAIL_HOST'] ?? '',
                        'mail.mailers.smtp.port' => $values['MAIL_PORT'] ?? '',
                        'mail.mailers.smtp.encryption' => $values['MAIL_ENCRYPTION'] ?? '',
                        'mail.mailers.smtp.username' => $values['MAIL_USERNAME'] ?? '',
                        'mail.mailers.smtp.password' => $values['MAIL_PASSWORD'] ?? '',
                        'mail.mailers.mailgun.domain' => $values['MAILGUN_DOMAIN'] ?? '',
                        'mail.mailers.mailgun.secret' => $values['MAILGUN_SECRET'] ?? '',
                        'mail.mailers.ses.key' => $values['SES_KEY'] ?? '',
                        'mail.mailers.ses.secret' => $values['SES_SECRET'] ?? '',
                        'mail.mailers.ses.region' => $values['SES_REGION'] ?? 'us-east-1',
                        'mail.mailers.postmark.token' => $values['POSTMARK_TOKEN'] ?? '',
                        'mail.from.address' => $values['MAIL_FROM_ADDRESS'] ?? '',
                        'mail.from.name' => $values['MAIL_FROM_NAME'] ?? '',
                    ]);
                }
            }
        }
    }
}