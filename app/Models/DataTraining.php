<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTraining extends Model
{
    use HasFactory, Uuids;

    protected $guarded = ['id'];

    public function datamentah()
    {
        return $this->belongsTo(DataMentah::class);
    }
}
