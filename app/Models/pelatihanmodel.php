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
        'id_jenis_pelatihan_sertifikasi',
        'level_pelatihan',
    ];

    public function periode():BelongsTo{
        return $this->belongsTo(periodemodel::class, 'id_periode', 'id_periode');
    }

    public function jenispelatihan():BelongsTo{
        return $this->belongsTo(jenispelatihansertifikasimodel::class);
    }

    public function vendorpelatihan():BelongsTo{
        return $this->belongsTo(vendorpelatihanmodel::class,'id_vendor_pelatihan', 'id_vendor_pelatihan');
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

    public function detailpelatihan():HasMany{
        return $this->hasMany(detailpelatihan::class, 'id_pelatihan', 'id_pelatihan');
    }

}
