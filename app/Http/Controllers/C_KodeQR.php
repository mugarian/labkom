<?php

namespace App\Http\Controllers;

use App\Models\KodeQR;
use Illuminate\Http\Request;

class C_KodeQR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kodeqr.index', [
            'title' => 'Kelola Kode QR'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\KodeQR  $kodeQR
     * @return \Illuminate\Http\Response
     */
    public function show(KodeQR $kodeQR)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KodeQR  $kodeQR
     * @return \Illuminate\Http\Response
     */
    public function edit(KodeQR $kodeQR)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KodeQR  $kodeQR
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KodeQR $kodeQR)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KodeQR  $kodeQR
     * @return \Illuminate\Http\Response
     */
    public function destroy(KodeQR $kodeQR)
    {
        //
    }

    public function cetak(KodeQR $kodeQR)
    {
        //
    }

}
