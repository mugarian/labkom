<?php

namespace App\Models;

use App\Models\User;
use App\Models\KodeQR;
use App\Models\Kondisi;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemakaian extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kodeqr() {
        return $this->belongsTo(KodeQR::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function peminjaman() {
        return $this->belongsTo(Peminjaman::class);
    }

    public function kondisi() {
        return $this->belongsTo(Kondisi::class);
    }
}
