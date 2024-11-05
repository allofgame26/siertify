<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class tagmkpelatihanmodel extends Model
{
    use HasFactory;

    protected $table = 't_tagging_mk_pelatihan';
    protected $primaryKey = 'id_tagging_mk';
    protected $fillable = ['id_mk','id_pelatihan'];


    public function matakuliah():BelongsTo{
        return $this->belongsTo(matakuliahmodel::class);
    }

    public function pelatihan():BelongsTo{
        return $this->belongsTo(pelatihanmodel::class);
    }
}
