<?php

namespace App\Models;

use App\Models\Bahan;
use App\Models\Laboratorium;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangHabis extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'string'
    ];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class);
    }
}
