<?php

namespace App\Http\Controllers\v1\Modules\General;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\System\Almanac;
use App\Exports\AlmanacsExport;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CreateAlmanacRequest;
use App\Http\Requests\UpdateAlmanacRequest;
use App\Repository\Contracts\AlmanacInterface;
use App\Http\Requests\CreateImportAlmanacRequest;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AlmanacController extends Controller
{
    public function __construct(private readonly AlmanacInterface $almanacRepository)
    {
    }
    public function index(): JsonResponse
    {
        $almanacs = $this->almanacRepository->getAll();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $almanacs, Almanac::class);
    }

    public function export(Request $request, $almanac): BinaryFileResponse
    {
        $type = $request->input('type');
        $documentFormat = $request->input('document');
        $fileName = $request->input('title');

        $export = new AlmanacsExport($type);
        $excelFormat = $documentFormat === 'pdf' ? \Maatwebsite\Excel\Excel::DOMPDF : \Maatwebsite\Excel\Excel::CSV;

        return Excel::download($export, $fileName, $excelFormat);
    }
    public function import(CreateImportAlmanacRequest $request): JsonResponse
    {
        $almanac = $this->almanacRepository->importAlmanac($request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $almanac, Almanac::class);
    }
    public function store(CreateAlmanacRequest $request): JsonResponse
    {
        $almanac = $this->almanacRepository->createAlmanac($request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $almanac, Almanac::class);
    }
    public function update(CreateAlmanacRequest $request, Almanac $almanac): JsonResponse
    {
        $almanac = $this->almanacRepository->updateAlmanac($almanac, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $almanac, Almanac::class);
    }
    public function approve(Almanac $almanac): JsonResponse
    {
        $almanac = $this->almanacRepository->approveAlmanac($almanac);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $almanac, Almanac::class);
    }
    public function markheldalmanac(Almanac $almanac): JsonResponse
    {
        $almanac = $this->almanacRepository->markHeldAlmanac($almanac);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $almanac, Almanac::class);
    }
    public function markcancelledalmanac(Almanac $almanac): JsonResponse
    {
        $almanac = $this->almanacRepository->markCancelledAlmanac($almanac);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $almanac, Almanac::class);
    }
    public function markpostponedalmanac(Almanac $almanac): JsonResponse
    {
        $almanac = $this->almanacRepository->markPostponedAlmanac($almanac);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $almanac, Almanac::class);
    }
    public function delete(UpdateAlmanacRequest $request, Almanac $almanac): JsonResponse
    {
        $almanac = $this->almanacRepository->deleteAlmanac($almanac, $request->validated());

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $almanac, Almanac::class);
    }
}