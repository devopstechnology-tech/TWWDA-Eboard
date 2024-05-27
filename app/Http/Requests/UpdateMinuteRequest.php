<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateMinuteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'meeting_id'   => RuleSet::create()->required()->string(),
            'board_id'     => RuleSet::create()->nullable()->string(),
            'committee_id' => RuleSet::create()->nullable()->string(),
            'membership_id' => RuleSet::create()->nullable()->string(),
            // // minutedetails
            'detail_minute_id' => RuleSet::create()->nullable()->string(),
            'minute_id'    => RuleSet::create()->nullable()->string(),
            'agenda_id'    => RuleSet::create()->required()->string(),
            'description'  => RuleSet::create()->required()->string(),
            'status'       => RuleSet::create()->required()->string(),
        ];
    }
}
