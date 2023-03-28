<?php

namespace App\Models;

use App\Models\User;
use App\Models\Kegiatan;
use App\Models\BarangHabis;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penggunaan extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function baranghabis()
    {
        return $this->belongsTo(BarangHabis::class);
    }
}
