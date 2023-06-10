<?php

namespace App\Http\Controllers;

use App\Models\Algoritma;
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
        $algoritmas = Algoritma::all();
        return view('v_algoritma.index', [
            'title' => 'Data Algoritma',
            'algoritmas' => $algoritmas
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
            'title' => 'Tambah Data algoritma',
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Algoritma  $algoritma
     * @return \Illuminate\Http\Response
     */
    public function show(Algoritma $algoritma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Algoritma  $algoritma
     * @return \Illuminate\Http\Response
     */
    public function edit(Algoritma $algoritma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Algoritma  $algoritma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Algoritma $algoritma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Algoritma  $algoritma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Algoritma $algoritma)
    {
        //
    }
}
