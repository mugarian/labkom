<?php

namespace App\Models;

use App\Models\User;
use App\Models\Laboratorium;
use App\Traits\Uuids;
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
        return $this->belongsTo(User::class);
    }

    public function laboratorium()
    {
        return $this->belongsTo(Laboratorium::class);
    }
}
