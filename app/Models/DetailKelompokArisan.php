<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KelompokArisan;
use App\Models\Peserta;

class DetailKelompokArisan extends Model
{
    protected $fillable = ['id_kelompok', 'id_peserta', 'ket_arisan', 'peringatan'];
    use HasFactory;

    public function kelompok_arisan()
    {
        return $this->belongsTo(KelompokArisan::class, 'id_kelompok');
    }
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
    public function kelompokGrup()
    {
        return $this->kelompok_arisan()
            ->selectRaw('id, count(*) as aggregate')
            ->groupBy('id');
    }
    public function pesertaGrup()
    {
        return $this->peserta()
            ->selectRaw('id, count(*) as aggregate')
            ->groupBy('id');
    }
}