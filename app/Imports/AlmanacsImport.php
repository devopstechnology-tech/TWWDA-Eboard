<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Utils\DateParser;
use App\Models\System\Almanac;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AlmanacsImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation
{
    use SkipsErrors;
    private $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }
    public function rules(): array
    {
        return [
            'type' => 'required|string',
            'purpose' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date',
            'budget_kshs' => 'required|numeric',
            'status' => 'required|string',
            'held' => 'required|string',
        ];
    }

    public function model(array $row)
    {

        // $startDateTime = Carbon::createFromFormat('d-m-Y H:i', trim($row['start']) . ' 08:00')->toDateTimeString();
        // $endDateTime = Carbon::createFromFormat('d-m-Y H:i', trim($row['end']) . ' 08:00')->toDateTimeString();

        // return new Almanac([
        //     'type'          => $row['type'],
        //     'purpose'       => $row['purpose'],
        //     'start'         => $startDateTime,
        //     'end'           => $endDateTime,
        //     'budget'        => $row['budget_kshs'],
        //     'status'        => $row['status'],
        //     'heldstatus'    => $row['held_status'],
        // ]);
        // dd($row['held_status']);
        $row = array_change_key_case($row, CASE_LOWER); // Convert all array keys to lowercase
        $startDateTime = DateParser::parseDate(trim($row['start']) . ' 08:00');
        $endDateTime = DateParser::parseDate(trim($row['end']) . ' 08:00');
        Log::info('Import Data', $row); // Log the data to review it
        return new Almanac([
            'type'          => $row['type'],
            'purpose'       => $row['purpose'],
            'start'         => $startDateTime,
            'end'           => $endDateTime,
            'budget'        => $row['budget_kshs'],
            'status'        => $row['status'],
            'held'    => $row['held'],
        ]);
    }
}