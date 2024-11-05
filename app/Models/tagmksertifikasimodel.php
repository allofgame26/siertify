<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tagmksertifikasimodel extends Model
{
    use HasFactory;

    protected $table = 't_tagging_mk_sertifikasi';
    protected $primaryKey = 'id_tagging_mk';
    protected $fillable = ['id_mk','id_sertifikasi'];

    public function matakuliah():BelongsTo{
        return $this->belongsTo(matakuliahmodel::class);
    }

    public function sertifikasi():BelongsTo{
        return $this->belongsTo(sertifikasimodel::class);
    }
}
