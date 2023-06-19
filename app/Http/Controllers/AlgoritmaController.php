<?php

namespace App\Http\Controllers;

use Algorithm\C45;
use App\Models\Algoritma;
use Algorithm\C45\DataInput;
use Illuminate\Http\Request;

class AlgoritmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainings = Algoritma::latest()->get();
        return view('v_algoritma.index', [
            'title' => 'Data Training',
            'trainings' => $trainings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v_algoritma.create', [
            'title' => 'Tambah Data training',
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
            'pengadaan' => 'required',
            'harga' => 'required',
            'label' => 'required',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        Algoritma::create($validatedData);
        return redirect('/training')->with('success', 'Tambah Data Training Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Algoritma  $algoritma
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $training = Algoritma::find($id);
        return view('v_algoritma.show', [
            'title' => 'Data Training ' . $training->nama,
            'training' => $training
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Algoritma  $algoritma
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $training = Algoritma::find($id);
        return view('v_algoritma.edit', [
            'title' => 'Data Training ' . $training->nama,
            'training' => $training
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Algoritma  $algoritma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $training = Algoritma::find($id);
        $rules = [
            'nama' => 'required|max:255',
            'pengajuan' => 'required',
            'harga' => 'required',
            'label' => 'required'
        ];

        $validatedData = $request->validate($rules);

        $training->update($validatedData);
        return redirect('/training')->with('success', 'Data Training berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Algoritma  $algoritma
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Algoritma::destroy($id);

        return redirect('/training')->with('success', 'Data training telah dihapus');
    }

    public function rule()
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
        $arrayTree = $buildTree->toArray(); // Set to array
        $stringTree = $buildTree->toString(); // Set to string

        $new_data = array(
            'pengajuan' => 'lebih',
            'harga' => 'mahal',
        );

        $rule = $c45->initialize()->buildTree()->toString();

        return view('v_algoritma.rule', [
            'title' => 'Hasil Rule',
            'rule' => $rule
        ]);
    }
}
