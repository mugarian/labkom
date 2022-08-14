<?php

namespace App\Http\Controllers;

use App\Models\KodeQR;
use Illuminate\Http\Request;

class C_ScanQR extends Controller
{
    public function index() {
        return view('scanqr.index', [
            'title' => 'Scan QR'
        ]);
    }

    public function scan(KodeQR $kodeQR) {

    }

    public function lapor(Request $request) {

    }

    public function pelaporan(KodeQR $kodeQR) {

    }

    public function melaporkan(Request $request) {

    }

    public function peminjaman(KodeQR $kodeQR) {

    }

    public function meminjam(Request $request) {

    }

    public function pemakaian(KodeQR $kodeQR) {

    }

    public function memakai(Request $request) {

    }

}
