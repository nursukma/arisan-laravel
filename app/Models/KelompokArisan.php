<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Arisan;

class KelompokArisan extends Model
{
    protected $fillable = ['nama_kelompok', 'id_arisan', 'keterangan', 'harga', 'status'];
    use HasFactory;

    public function arisan()
    {
        return $this->belongsTo(Arisan::class);
    }
}