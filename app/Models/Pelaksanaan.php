<?php

namespace App\Models;

use App\Models\Dosen;
use App\Traits\Uuids;
use App\Models\Pemakaian;
use App\Models\Laboratorium;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelaksanaan extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'string'
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
