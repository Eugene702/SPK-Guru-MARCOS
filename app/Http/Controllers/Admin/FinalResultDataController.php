<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FinalResultDataController extends Controller
{
    public function index()
    {
        try {
            $calculateReportService = app(\App\Services\CalculateReportService::class);
            return view('admin.finalResultData.index', ['ranking' => $calculateReportService->calculate()['ranking']]);
        } catch (\Exception $e) {
            abort(500, 'Ada kesalahhan pada server!');
        }
    }

    public function print()
    {
        try {
            $calculateReportService = app(\App\Services\CalculateReportService::class);
            return Pdf::loadView('admin.finalResultData.components.print', ['ranking' => $calculateReportService->calculate()['ranking']])
                ->download("Hasil Akhir" . " " . Carbon::now()->format('Y') . ".pdf");
        } catch (\Exception $e) {
            if(config("app.debug")){
                dd($e);
            }
            abort(500, 'Ada kesalahhan pada server!');
        }
    }
}
