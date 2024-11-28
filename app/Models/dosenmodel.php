<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class dosenmodel extends Model
{
    use HasFactory;

    protected $table = 't_dosen';
    protected $primaryKey = 'id_dosen';

    protected $fillable = ['id_user'];

    public function user(): BelongsTo{
        return $this->belongsTo(akunusermodel::class, 'id_user', 'id_user');
    }

    public function detailbd():HasMany{
        return $this->hasMany(detailbddosen::class,'id_dosen','id_dosen');
    }

    public function detailmk():HasMany{
        return $this->hasMany(detailmkdosen::class,'id_dosen','id_dosen');
    }
}
