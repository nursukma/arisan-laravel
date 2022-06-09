<?php

namespace App\Models;

use App\Models\KelompokArisan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Arisan extends Model
{
    protected $fillable = ['nama_arisan', 'keterangan', 'slot', 'harga'];
    use HasFactory;
    public function kelompok_arisan()
    {
        return $this->hasMany(KelompokArisan::class);
    }
}