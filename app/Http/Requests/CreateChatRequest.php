<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateChatRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // discussion_id
            // assignee_sender_id
            // assignee_receiver_id
            // message
            // editstatus
            // file
            // Your rules here
            'id' => RuleSet::create()->sometimes(),
            'discussion_id' => RuleSet::create()->required()->string(),
            'assignee_sender_id' => RuleSet::create()->sometimes(),
            'assignee_receiver_id' => RuleSet::create()->sometimes(),
            'message' => RuleSet::create()->required()->string(),
            'file' => RuleSet::create()->sometimes(),
        ];
    }
}