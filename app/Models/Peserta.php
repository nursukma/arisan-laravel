<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = ['nm_peserta', 'alamat', 'no_tlp'];
    use HasFactory;
}