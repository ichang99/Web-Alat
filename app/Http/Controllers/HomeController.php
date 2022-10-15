<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $alat = Alat::where('qty','!=', 0)->count();
        $pinjam = Peminjaman::where('status', 'Belum Dikembalikan')->count();
        return view('main', compact('alat','pinjam'));
    }
}
