<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Arisan;
use App\Models\DetailKelompokArisan;
use App\Models\Pembayaran;

class KelompokArisan extends Model
{
    protected $fillable = ['nama_kelompok', 'id_arisan', 'keterangan', 'harga', 'status', 'slot'];
    use HasFactory;

    public function arisan()
    {
        return $this->belongsTo(Arisan::class);
    }
    public function detail_kelompok_arisan()
    {
        return $this->hasMany(DetailKelompokArisan::class);
    }
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
    public function detail()
    {
        return $this->hasMany(DetailKelompokArisan::class);
    }
}