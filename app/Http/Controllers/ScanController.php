<?php

namespace App\Http\Controllers;

use App\Models\BahanJurusan;
use App\Models\BahanPraktikum;
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
        $barangpakai = barangpakai::where('kode', $kode)->first();
        $bahanpraktikum = bahanpraktikum::where('kode', $kode)->first();
        $bahanjurusan = BahanJurusan::where('kode', $kode)->first();

        if ($barangpakai) {
            // return view('v_pemakaian.pakai', [
            //     'title' => 'Tambah Data Pemakaian',
            //     'barangpakai' => $barangpakai
            // ]);
            return redirect('/barangpakai/' . $barangpakai->id)->with('success', 'Kode QR ditemukan');
            // return view('v_barangpakai.show', [
            //     'title' => $barangpakai->nama,
            //     'barangpakai' => $barangpakai,
            //     'qrcode' => $qrbp
            // ]);
        } elseif ($bahanpraktikum) {
            return redirect('/bahanpraktikum/' . $bahanpraktikum->id)->with('success', 'Kode QR ditemukan');
            // return view('v_bahanpraktikum.show', [
            //     'title' => $bahanpraktikum->nama,
            //     'bahanpraktikum' => $bahanpraktikum,
            //     'qrcode' => $qrbh
            // ]);
        } else if ($bahanjurusan) {
            return redirect('/bahanjurusan/' . $bahanjurusan->id)->with('success', 'Kode QR ditemukan');
        } else {
            return redirect('/scan')->with('fail', 'Kode QR tidak ditemukan');
        }
    }

    public function printQR($kode, $jenis)
    {
        switch ($jenis) {
            case 'barangpakai':
                # code...
                break;
            case 'bahanpraktikum':
                # code...
                break;
            case 'bahanjurusan':
                # code...
                break;

            default:
                # code...
                break;
        }
    }

    public function printData($jenis)
    {
        switch ($jenis) {
            case 'pelaksanaan':
                # code...
                break;
            case 'permohonan':
                # code...
                break;
            case 'pemakaian':
                # code...
                break;
            case 'penggunaan':
                # code...
                break;
            case 'peminjamanalat':
                # code...
                break;
            case 'peminjamanbahan':
                # code...
                break;
            case 'pengajuan':
                # code...
                break;
            default:
                # code...
                break;
        }
    }
}
