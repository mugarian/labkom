<?php

namespace App\Http\Controllers;

use App\Models\DataTraining;
use App\Http\Requests\StoreDataTrainingRequest;
use App\Http\Requests\UpdateDataTrainingRequest;

class DataTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreDataTrainingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDataTrainingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataTraining  $dataTraining
     * @return \Illuminate\Http\Response
     */
    public function show(DataTraining $dataTraining)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataTraining  $dataTraining
     * @return \Illuminate\Http\Response
     */
    public function edit(DataTraining $dataTraining)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDataTrainingRequest  $request
     * @param  \App\Models\DataTraining  $dataTraining
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDataTrainingRequest $request, DataTraining $dataTraining)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataTraining  $dataTraining
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataTraining $dataTraining)
    {
        //
    }
}
