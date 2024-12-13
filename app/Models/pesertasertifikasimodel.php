<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pesertasertifikasimodel extends Model
{
    use HasFactory;

    protected $table = 't_peserta_sertifikasi';
    protected $primaryKey = 'id_peserta';
    protected $fillable = ['id_user','id_detail_sertifikasi '];

    public function sertifikasi():BelongsTo{
        return $this->belongsTo(detailsertifikasi::class,'id_detail_sertifikasi','id_detail_sertifikasi');
    }

    public function akun():BelongsTo{
        return $this->belongsTo(akunusermodel::class,'id_user','id_user');
    }
}
