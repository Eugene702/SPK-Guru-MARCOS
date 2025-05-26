<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Perhitungan;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $calculation = Perhitungan::whereHas('guru', function ($query) {
                    $query->where('jabatan', '=', 'Guru');
                })
                ->whereYear('created_at', '>=', now()->subYears(5)->startOfYear())
                ->with('guru.user')
                ->get()
                ->groupBy(function($item){
                    return $item->created_at->format("Y");
                })
                ->sortKeysDesc();

            $calculateReportService = app(\App\Services\CalculateReportService::class);
            $barChartData = collect($calculation->map(function($items) use($calculateReportService){
                $result = $calculateReportService->calculate($items)['ranking'];
                return round(100 * collect($result)->avg('fk'), 2);
            }));

            return view('admin.index', [
                'ranking' => $calculation->has(now()->year) ? $calculateReportService->calculate($calculation[now()->year])['ranking'] : [],
                'barChartData' => $barChartData,
            ]);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e);
            }
            return redirect()->back()->with('error', 'Ada kesalahan pada server!');
        }
    }

    public function addguru()
    {
        $user = User::with('guru')
            ->where('role', 'Guru')
            ->get();
        $guru = Guru::all(); // Ambil semua data guru dari database

        return view('admin.addguru', compact('guru', 'user'));
    }
}

