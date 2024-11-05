<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class jenispelatihansertifikasimodel extends Model
{
    use HasFactory;

    protected $table = 'm_jenis_pelatihan_sertifikasi';
    protected $primaryKey = 'id_jenis_pelatihan_sertifikasi';

    protected $fillable = ['nama_jenis_pelatihan','deskripsi_pendek'];

    public function sertifikasi():HasMany{
        return $this->hasMany(sertifikasimodel::class);
    }

    public function pelatihan():HasMany{
        return $this->hasMany(pelatihanmodel::class);
    }
}
