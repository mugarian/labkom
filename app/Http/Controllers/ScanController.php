<?php

namespace App\Http\Controllers;

use App\Models\BarangHabis;
use App\Models\BarangPakai;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ScanController extends Controller
{

    public function index()
    {
        return view('v_scanqr', [
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
            return redirect('/barangpakai/' . $barangpakai->id);
            // return view('v_barangpakai.show', [
            //     'title' => $barangpakai->nama,
            //     'barangpakai' => $barangpakai,
            //     'qrcode' => $qrbp
            // ]);
        } elseif ($baranghabis) {
            return redirect('/baranghabis/' . $baranghabis->id);
            // return view('v_baranghabis.show', [
            //     'title' => $baranghabis->nama,
            //     'baranghabis' => $baranghabis,
            //     'qrcode' => $qrbh
            // ]);
        } else {
            return redirect('/scan')->with('fail', 'Kode tidak ditemukan');
        }
    }
}
