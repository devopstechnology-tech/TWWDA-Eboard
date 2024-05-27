<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use App\Models\System\Almanac;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;

class AlmanacsExport implements WithHeadings, WithMapping, Responsable, FromQuery
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return Almanac::all();
    // }
    use Exportable;

    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'almanacs-import-template.csv';
    private $sample;
    /**
     * Optional Writer Type
     */
    private $writerType = Excel::CSV;
    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function __construct(string $sample)
    {
        $this->sample = $sample;
    }

    public function query()
    {
        return Almanac::query()->where('type', $this->sample);
    }

    public function map($almanac): array
    {
        return [
            $almanac->type,
            $almanac->purpose,
            Carbon::parse($almanac->start)->format('d-m-Y'),
            Carbon::parse($almanac->end)->format('d-m-Y'),
            $almanac->budget,
            $almanac->status,
            $almanac->held,
        ];
    }
    public function headings(): array
    {
        return [
            'Type',
            'Purpose',
            'Start',
            'End',
            'Budget (KShs)',
            'Status',
            'Held',
        ];
    }
}