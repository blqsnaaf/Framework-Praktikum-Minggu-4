<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTransaksi extends Model
{
    use HasFactory;
    protected $table = 'jenis_transaksi'; // Nama tabel eksplisit

    protected $fillable = [
    'jenis_transaksi',
    'keterangan',
    'tanggal_lahir',
    'foto_ktp'
];
}
