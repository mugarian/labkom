<?php

namespace App\Http\Controllers;

use App\Models\BarangHabis;
use App\Models\BarangPakai;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{

    public function index()
    {
        return view('v_scanqr.index', [
            'title' => 'Scan QR',
        ]);
    }

    public function search(Request $request)
    {
        $kode = $request->search;
        return $this->scan($kode);
    }

    public function scan($kode)
    {
        $barangpakai = BarangPakai::where('kode', $kode)->first();
        $baranghabis = BarangHabis::where('kode', $kode)->first();

        if ($barangpakai) {
            return view('v_pemakaian.pakai', [
                'title' => 'Tambah Data Pemakaian',
                'barangpakai' => $barangpakai
            ]);
        } elseif ($baranghabis) {
            return view('v_penggunaan.guna', [
                'title' => 'Tambah Data Penggunaan',
                'baranghabis' => $baranghabis
            ]);
        } else {
            return redirect('/scan')->with('fail', 'Kode tidak ditemukan');
        }
    }
}
