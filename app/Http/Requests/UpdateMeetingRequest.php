<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class UpdateMeetingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'board_id' => RuleSet::create()->nullable(),
            'committee_id' => RuleSet::create()->nullable(),
            'conference' => RuleSet::create()->required()->string(),
            'description' => RuleSet::create()->required()->string(),
            'end_time' => RuleSet::create()->required()->string(),
            'link' => RuleSet::create()->nullable()->string(),
            'location' => RuleSet::create()->required()->string(),
            'owner_id' => RuleSet::create()->sometimes()->string(),
            'start_time' => RuleSet::create()->required()->string(),
            'status' => RuleSet::create()->required()->string(),
            'timezone' => RuleSet::create()->required()->string(),
            'title' => RuleSet::create()->required()->string(),
            'type' => RuleSet::create()->required()->string(),
        ];
    }
}
