<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
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

