<?php

namespace App\Models;

use App\Http\Models\KelompokArisan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arisan extends Model
{
    protected $fillable = ['nama_arisan', 'keterangan', 'slot', 'harga'];
    use HasFactory;
    public function arisan()
    {
        return $this->hasMany(KelompokArisan::class);
    }
}