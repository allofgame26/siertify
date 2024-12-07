<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detailbddosen extends Model
{
    use HasFactory;

    protected $table = 'm_detailbddosen';
    protected $primaryKey = 'id_detailbd';

    protected $fillable = ['id_user','id_bd'];

    public function dosen(): BelongsTo{
        return $this->belongsTo(akunusermodel::class, 'id_user', 'id_user');
    
    }

    public function bidangminat(): BelongsTo{
        return $this->belongsTo(bidangminatmodel::class, 'id_bd', 'id_bd');
    }

}
