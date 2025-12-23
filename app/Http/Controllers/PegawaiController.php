<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login saat ini
        $user = Auth::user();

        // Tampilkan view dashboard pegawai dan kirim datanya
        return view('pegawai.dashboard', compact('user'));
    }
}