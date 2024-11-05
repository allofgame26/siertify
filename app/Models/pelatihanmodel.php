<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pelatihanmodel extends Model
{
    use HasFactory;

    protected $table = 'm_pelatihan';
    protected $primaryKey = 'id_pelatihan';

    protected $fillable = [
        'nama_pelatihan',
        'id_vendor_pelatihan',
        'id_jenis_pelatihan',
        'id_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'level_pelatihan',
        'lokasi',
        'biaya',
        'quota_peserta',
        'no_pelatihan',
        'bukti_pelatihan',
        'status_disetujui',
        'input_by'
    ];

    public function periode():BelongsTo{
        return $this->belongsTo(periodemodel::class);
    }

    public function jenispelatihan():BelongsTo{
        return $this->belongsTo(jenispelatihansertifikasimodel::class);
    }

    public function vendorpelatihan():BelongsTo{
        return $this->belongsTo(vendorpelathihanmodel::class);
    }

    public function pesertapelatihan():HasMany{
        return $this->hasMany(pesertapelatihanmodel::class);
    }

    public function tagmk():HasMany{
        return $this->hasMany(tagmkpelatihanmodel::class);
    }

    public function tagbd():HasMany{
        return $this->hasMany(tagbdpelatihanmodel::class);
    }

}
