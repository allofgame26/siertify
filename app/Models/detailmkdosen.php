<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detailmkdosen extends Model
{
    use HasFactory;

    protected $table = 't_detailmkdosen';
    protected $primaryKey = 'id_detailmk';

    protected $fillable = ['id_user','id_mk'];

    public function dosen(): BelongsTo{
        return $this->belongsTo(akunusermodel::class, 'id_user', 'id_user');
    
    }
    public function matakuliah(): BelongsTo{
        return $this->belongsTo(akunusermodel::class, 'id_user', 'id_user');
    }

}
