<?php

namespace App\Models;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Traits\Uuids;
use App\Models\Laboratorium;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kegiatan extends Model
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

    public function dospem()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function matakuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }
}
