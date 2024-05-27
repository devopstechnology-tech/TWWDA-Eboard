<?php

declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Sourcetoad\RuleHelper\RuleSet;

class CreateBoardFileFolderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Your rules here
            'board_id' => Ruleset::create()->required()->string(),
            'name' => Ruleset::create()->required()->string(),
            'parent_id' => Ruleset::create()->required()->string(),
            'type' => Ruleset::create()->required()->string(),
            'fileupload' => Ruleset::create()
                        ->required()->file()
                        ->mimes(
                            'pdf',
                            'doc',
                            'docx',
                            'xls',
                            'xlsx',
                            'ppt',
                            'pptx',
                            'dwg',
                            'dxf',
                            'stl',
                            'step',
                            'stp',
                            'iges',
                            'igs',
                            'plc',
                            'scad'
                        ),
        ];
    }
}
