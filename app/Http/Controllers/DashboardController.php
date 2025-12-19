<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /**
         * Mengambil user yang sedang login
         * --------------------------------
         * $request->user() mengambil data user dari session authentication
         * Ini setara dengan auth()->user(), tapi lebih eksplisit & aman
         */
        $user = $request->user();
    
        /**
         * Cek role user
         * -------------
         * Jika role user adalah 'admin',
         * maka tampilkan dashboard khusus admin
         */
        if ($user->role === 'admin') {
            return view('dashboard.admin');
        }
    
        /**
         * Jika role BUKAN admin (misalnya user biasa),
         * maka tampilkan dashboard user
         */
        return view('dashboard.user');
    }
    
}
