<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class detailpelatihan extends Model
{
    use HasFactory;

    protected $table = 't_detailpelatihan';
    protected $primaryKey = 'id_detail_pelatihan';

    protected $fillable = [
        'id_pelatihan',
        'id_periode',
        'id_user',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'quota_peserta',
        'biaya',
        'no_pelatihan',
        'status_disetujui',
        'input_by',
        'surat_tugas'
    ];

    public function pelatihan():BelongsTo{
        return $this->belongsTo(pelatihanmodel::class,'id_pelatihan','id_pelatihan');
    }

    public function periode():BelongsTo{
        return $this->belongsTo(periodemodel::class,'id_periode','id_periode');
    
    }
    public function akun():BelongsTo{
        return $this->belongsTo(akunusermodel::class,'id_user','id_user');
    }

    public function peserta():HasMany{
        return $this->hasMany(pesertapelatihanmodel::class,'id_detail_pelatihan','id_detail_pelatihan');
    }
    
}
