<?php

namespace App\Models;

use App\Models\Alat;
use App\Models\Laboratorium;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangPakai extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'string'
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class);
    }
}
