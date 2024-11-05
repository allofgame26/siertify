<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class bidangminatmodel extends Model
{
    use HasFactory;

    protected $table = 'm_bidang_minat';
    protected $primaryKey = 'id_bd';

    protected $fillable = ['nama_bd','kode_bd','deskripsi_bd'];

    public function tagbdpelatihan():HasMany{
        return $this->hasMany(tagbdpelatihanmodel::class);
    }

    public function tagbdsertifikasi():HasMany{
        return $this->hasMany(tagbdsertifikasimodel::class);
    }
}
