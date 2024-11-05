<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class periodemodel extends Model
{
    use HasFactory;

    protected $table = 'm_periode';
    protected $primaryKey = 'id_periode';

    protected $fillable = ['nama_periode','tanggal_mulai','tanggal_selesai','tahun_periode','deskripsi_periode'];

    public function sertifikasi():HasMany{
        return $this->hasMany(sertifikasimodel::class);
    }

    public function pelatihan():HasMany{
        return $this->hasMany(pelatihanmodel::class);
    }
}
