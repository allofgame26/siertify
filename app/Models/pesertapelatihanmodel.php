<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pesertapelatihanmodel extends Model
{
    use HasFactory;

    protected $table = 't_peserta_pelatihan';
    protected $primaryKey = 'id_peserta';
    protected $fillable = ['id_user','id_detail_pelatihan'];

    public function detailpelatihan():BelongsTo{
        return $this->belongsTo(detailpelatihan::class,'id_detail_pelatihan','id_detail_pelatihan');
    }

    public function akun():BelongsTo{
        return $this->belongsTo(akunusermodel::class,'id_user','id_user');
    }

}
