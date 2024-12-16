<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tagbdpelatihanmodel extends Model
{
    use HasFactory;

    protected $table = 't_tagging_bd_pelatihan';
    protected $primaryKey = 'id_tagging_bd';
    protected $fillable = ['id_bd','id_pelatihan'];

    public function bidangminat():BelongsTo{
        return $this->belongsTo(bidangminatmodel::class,'id_bd','id_bd');
    }

    public function pelatihan():BelongsTo{
        return $this->belongsTo(pelatihanmodel::class,'id_pelatihan','id_pelatihan');
    }
}
