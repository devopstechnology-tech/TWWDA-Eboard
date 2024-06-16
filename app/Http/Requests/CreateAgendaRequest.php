<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateAgendaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => RuleSet::create()->required()->string(),
            'schedule_id' => RuleSet::create()->required()->string(),
        ];
    }
}