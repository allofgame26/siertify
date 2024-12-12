<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detailsertifikasi extends Model
{
    use HasFactory;

    protected $table = 't_detailsertifikasi';
    protected $primaryKey = 'id_detail_sertifikasi';

    protected $fillable = [
        'id_sertifikasi',
        'id_periode',
        'id_user',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'quota_peserta',
        'biaya',
        'no_sertifikasi',
        'bukti_sertifikasi',
        'tanggal_kadaluarsa',
        'status_disetujui',
        'input_by',
    ];


    public function sertifikasi():BelongsTo{
        return $this->belongsTo(sertifikasimodel::class);
    }

    public function periode():BelongsTo{
        return $this->belongsTo(periodemodel::class, 'id_periode', 'id_periode');
    }

}
