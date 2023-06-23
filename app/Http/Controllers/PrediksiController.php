<?php

namespace App\Http\Controllers;

use Algorithm\C45;
use App\Models\User;
use App\Models\Prediksi;
use App\Models\Algoritma;
use Algorithm\C45\DataInput;
use Illuminate\Http\Request;

class PrediksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);

        if ($user->role == 'admin') {
            $prediksis = Prediksi::latest()->get();
        } else {
            $prediksis = Prediksi::where('user_id', $user->id)->latest()->get();
        }

        return view('v_prediksi.index', [
            'title' => 'Data prediksi',
            'prediksis' => $prediksis
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v_prediksi.create', [
            'title' => 'Tambah Data Prediksi',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'jml_pengajuan' => 'required',
            'jml_matkul' => 'required',
            'jml_siswa' => 'required',
            'jml_kelas' => 'required',
            'harga_barang' => 'required',
            'harga_termurah' => 'required',
            'harga_termahal' => 'required',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $jml_kuota = $validatedData['jml_matkul'] * $validatedData['jml_siswa'] * $validatedData['jml_kelas'];
        if ($validatedData['jml_pengajuan'] > $jml_kuota) {
            $pengajuan = 'lebih';
        } elseif ($validatedData['jml_pengajuan'] = $jml_kuota) {
            $pengajuan = 'pas';
        } else {
            $pengajuan = 'kurang';
        }

        $harga_ratarata = ($validatedData['harga_termurah'] + $validatedData['harga_termahal']) / 2;
        $harga = ($validatedData['harga_barang'] > $harga_ratarata) ? 'mahal' : 'murah';

        $validatedData['pengajuan'] = $pengajuan;
        $validatedData['harga'] = $harga;

        $validatedData['label'] = $this->prediksi($pengajuan, $harga);

        $prediksi = Prediksi::create($validatedData);
        return redirect('/prediksi/' . $prediksi->id)->with('success', 'Tambah Data prediksi Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prediksi  $prediksi
     * @return \Illuminate\Http\Response
     */
    public function show(Prediksi $prediksi)
    {
        return view('v_prediksi.show', [
            'title' => 'Data Prediksi ' . $prediksi->nama,
            'prediksi' => $prediksi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prediksi  $prediksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Prediksi $prediksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prediksi  $prediksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prediksi $prediksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prediksi  $prediksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prediksi $prediksi)
    {
        try {
            Prediksi::destroy($prediksi->id);

            return redirect('/prediksi')->with('success', 'Data Prediksi telah dihapus');
        } catch (\Throwable $th) {
            return redirect('/prediksi')->with('fail', 'Gagal Menghapus Data karena Data Terhubung dengan Data Lain');
        }
    }

    public function prediksi($pengajuan, $harga)
    {
        $c45 = new C45();
        $input = new DataInput;
        $trainings = Algoritma::all();
        $atts = array();
        $count = 0;
        foreach ($trainings as $training) {
            $atts[$count++] = array(
                "pengajuan" => $training->pengajuan,
                "harga" => $training->harga,
                "label" => $training->label,
            );
        }

        // Initialize Data
        $input->setData($atts); // Set data from array
        $input->setAttributes(array('harga', 'pengajuan', 'label')); // Set attributes of data

        // Initialize C4.5
        $c45->c45 = $input; // Set input data
        $c45->setTargetAttribute('label'); // Set target attribute
        $initialize = $c45->initialize(); // initialize

        // Build Output
        $buildTree = $initialize->buildTree(); // Build tree

        $new_data = array(
            'pengajuan' => $pengajuan,
            'harga' => $harga,
        );

        $label = $c45->initialize()->buildTree()->classify($new_data);
        return $label;
    }
}
