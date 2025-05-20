<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        try{
            $calculateReportService = app(\App\Services\CalculateReportService::class);
            return view('admin.index', [
                'ranking' => $calculateReportService->calculate()['ranking']
            ]);
        }catch(\Exception $e){
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

