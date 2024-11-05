<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tagbdsertifikasimodel extends Model
{
    use HasFactory;

    protected $table = 't_tagging_bd_sertifikasi';
    protected $primaryKey = 'id_tagging_bd';
    protected $fillable = ['id_bd','id_sertifikasi'];

    public function bidangminat():BelongsTo{
        return $this->belongsTo(bidangminatmodel::class);
    }

    public function sertifikasi():BelongsTo{
        return $this->belongsTo(sertifikasimodel::class);
    }
}
