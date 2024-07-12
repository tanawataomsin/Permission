<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลผู้ใช้ปัจจุบัน
        $user = Auth::user();

        return view('dashboard', compact('user'));
    }
}
