<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Module\Meeting\Minute;
use App\Models\Module\Meeting\Minute\MinuteReview;
use App\Models\Users\Staff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateStaffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first' => RuleSet::create()
                ->sometimes()
                ->string(),
            'last' => RuleSet::create()
                ->sometimes()
                ->string(),
            'title' => RuleSet::create()
                ->sometimes()
                ->string(),
            'id_number' => RuleSet::create()
                ->sometimes()
                ->string()
                ->min(5)
                ->unique(
                    Staff::class,
                    'id_number',
                    fn(Unique $rule) => $rule->ignore($this->staff)
                ),
            'phone' => RuleSet::create()
                ->sometimes()
                ->string()
                ->min(10),
            'email' => RuleSet::create()
                ->sometimes()
                ->string()
                ->email()
                ->unique(
                    Staff::class,
                    'email',
                    fn(Unique $rule) => $rule->ignore($this->staff)
                ),
            'status' => RuleSet::create()
                ->sometimes()
                ->string(),
            'description' => RuleSet::create()
                ->sometimes()
                ->string(),
            'image' => RuleSet::create()
                ->sometimes()
                ->file(),
        ];
    }
}

// Minute
// DetailMinute
// MinuteReview
// php artisan make:repository Minute
// php artisan make:repository DetailMinute
// php artisan make:repository MinuteReview
// php artisan make:resource Minute
// php artisan make:resource DetailMinute
// php artisan make:resource MinuteReview
// php artisan make:request Minute -u
// php artisan make:request DetailMinute -u
// php artisan make:request MinuteReview -u
// php artisan make:controller v1/Modules/Meeting/MinuteController
// php artisan make:controller v1/Modules/Meeting/Minute/DetailMinuteController
// php artisan make:controller v1/Modules/Meeting/Minute/Minute/MinuteReviewController
