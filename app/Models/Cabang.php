<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    protected $fillable = ['nama_cabang', 'alamat_cabang', 'logo', 'kota_cabang', 'no_kontak', 'deskripsi', 'status'];
}
