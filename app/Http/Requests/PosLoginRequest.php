<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id_number' => ['required', 'string'],
            'password' => 'required',
        ];
    }
}
