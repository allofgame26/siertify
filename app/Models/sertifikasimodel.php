<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class sertifikasimodel extends Model
{
    use HasFactory;
    protected $table = 'm_sertifikasi';
    protected $primaryKey = 'id_sertifikasi';

    protected $fillable = [
        'nama_sertifikasi',
        'id_vendor_sertifikasi',
        'id_jenis_pelatihan_sertifikasi',
        'level_sertifikasi'
    ];

    public function periode():BelongsTo{
        return $this->belongsTo(periodemodel::class);
    }

    public function jenissertifikasi():BelongsTo{
        return $this->belongsTo(jenispelatihansertifikasimodel::class,'id_jenis_pelatihan_sertifikasi','id_jenis_pelatihan_sertifikasi');
    }

    public function vendorsertifikasi():BelongsTo{
        return $this->belongsTo(vendorsertifikasimodel::class,'id_vendor_sertifikasi','id_vendor_sertifikasi');
    }

    public function pesertasertifikasi():HasMany{
        return $this->hasMany(pesertasertifikasimodel::class);
    }

    public function tagmk():HasMany{
        return $this->hasMany(tagmksertifikasimodel::class);
    }

    public function tagbd():HasMany{
        return $this->hasMany(tagbdsertifikasimodel::class);
    }

}
