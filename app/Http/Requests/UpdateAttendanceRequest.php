<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateAttendanceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here for update
            'location' => RuleSet::create()->sometimes(),
            'rsvp_status' => RuleSet::create()->sometimes(),
            'attendance_status' => RuleSet::create()->sometimes(),
            'schedule_id' => RuleSet::create()->sometimes(),
            'membership_id' => RuleSet::create()->sometimes(),
        ];
    }
}