<?php

namespace App\Models;

use App\Models\User;
use App\Models\Barang;
use App\Models\KodeQR;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruangan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function barang() {
        return $this->hasMany(Barang::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function kodeqr() {
        return $this->belongsTo(KodeQR::class);
    }
}
