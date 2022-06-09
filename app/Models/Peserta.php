<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailKelompokArisan;
use App\Models\Pembayaran;
use App\Models\User;


class Peserta extends Model
{
    protected $fillable = ['nm_peserta', 'alamat', 'no_tlp', 'stts', 'sttsPeserta', 'email'];
    use HasFactory;

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
    public function user()
    {
        return $this->hasOne(User::class);
    }
}