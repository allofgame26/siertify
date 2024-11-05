<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class matakuliahmodel extends Model
{
    use HasFactory;

    protected $table = 'm_mata_kuliah';
    protected $primaryKey = 'id_mk';

    protected $fillable = ['nama_mk','kode_mk','deskripsi_mk'];

    public function tagmkpelatihan():HasMany{
        return $this->hasMany(tagmkpelatihanmodel::class);
    }

    public function tagmksertifkasi():HasMany{
        return $this->hasMany(tagmksertifikasimodel::class);
    }
}
