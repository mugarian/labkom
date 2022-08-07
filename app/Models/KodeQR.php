<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\Pelaporan;
use App\Models\Pemakaian;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KodeQR extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function barang() {
        return $this->hasMany(Barang::class);
    }

    public function ruangan() {
        return $this->hasMany(Ruangan::class);
    }

    public function peminjaman() {
        return $this->hasMany(Peminjaman::class);
    }

    public function pemakaian() {
        return $this->hasMany(Pemakaian::class);
    }

    public function pelaporan() {
        return $this->hasMany(Pelaporan::class);
    }
}
