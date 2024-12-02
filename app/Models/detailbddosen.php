<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detailbddosen extends Model
{
    use HasFactory;

    protected $table = 't_detailbddosen';
    protected $primaryKey = 'id_detailbd';

    protected $fillable = ['id_dosen','id_bd'];

    public function dosen(): BelongsTo{
        return $this->belongsTo(dosenmodel::class, 'id_dosen', 'id_dosen');
    
    }
    public function bidangminat(): BelongsTo{
        return $this->belongsTo(bidangminatmodel::class, 'id_bd', 'id_bd');
    }

}
