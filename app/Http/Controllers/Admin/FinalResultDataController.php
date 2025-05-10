<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinalResultDataController extends Controller
{
    public function index(){
        try{
            $calculateReportService = app(\App\Services\CalculateReportService::class);
            return view('admin.finalResultData.index', ['hasil' => $calculateReportService->calculate()['hasil']]);
        }catch(\Exception $e){
            abort(500, 'Ada kesalahhan pada server!');
        }
    }
}
