<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class notifikasimodel extends Model
{
    use HasFactory;

    protected $table = 't_notifikasi_user';
    protected $primaryKey = 'id';

    protected $fillable = ['id_user','pesan','is_read', 'id_detail_pelatihan', 'id_detail_sertifikasi'. 'created_at', 'updated_at'];

    public function pelatihan():BelongsTo{
        return $this->belongsTo(pelatihanmodel::class,'id_pelatihan','id_pelatihan');
    }

    public function sertifikasi():BelongsTo{
        return $this->belongsTo(sertifikasimodel::class, 'id_sertifikasi', 'id_sertifikasi');
    }

    public function akun():BelongsTo{
        return $this->belongsTo(akunusermodel::class,'id_user','id_user');
    }



}