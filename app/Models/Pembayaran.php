<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peserta;
use App\Models\KelompokArisan;

class Pembayaran extends Model
{
    protected $fillable = ['id_kelompok', 'id_peserta', 'tgl_setor', 'stts', 'id_detail_kelompok'];
    use HasFactory;

    public function kelompok_arisan()
    {
        return $this->belongsTo(KelompokArisan::class, 'id_kelompok');
    }
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
    public function detail_kelompok_arisan()
    {
        return $this->belongsTo(DetailKelompokArisan::class, 'id_detail_kelompok');
    }
}