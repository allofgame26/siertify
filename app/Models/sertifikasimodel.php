<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class sertifikasimodel extends Model
{
    use HasFactory;
    protected $table = 'm_sertifikasi';
    protected $primaryKey = 'id_sertifikasi';

    protected $fillable = [
        'nama_sertifikasi',
        'id_vendor_sertifikasi',
        'id_jenis_sertifikasi',
        'id_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'level_sertifikasi',
        'lokasi',
        'biaya',
        'quota_peserta',
        'no_sertifikat',
        'tanggal_kadaluarsa',
        'bukti_sertifikat',
        'status_disetujui',
        'input_by'
    ];

    public function periode():BelongsTo{
        return $this->belongsTo(periodemodel::class);
    }

    public function jenissertifikasi():BelongsTo{
        return $this->belongsTo(jenispelatihansertifikasimodel::class);
    }

    public function vendorsertifikasi():BelongsTo{
        return $this->belongsTo(vendorpelathihanmodel::class);
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
