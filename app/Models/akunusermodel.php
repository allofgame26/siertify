<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class akunusermodel extends Model
{
    use HasFactory;

    protected $table = 'm_akun_user';
    protected $primaryKey = 'id_user';

    protected $fillable = ['id_identitas','id_jenis_pengguna','username','password','id_periode'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function identitas():BelongsTo{
        return $this->belongsTo(identitasmodel::class, 'id_identitas', 'id_identitas');
    }

    public function jenis_pengguna():BelongsTo{
        return $this->belongsTo(jenispenggunamodel::class, 'id_jenis_pengguna', 'id_jenis_pengguna');
    }

    public function periode():BelongsTo{
        return $this->belongsTo(periodemodel::class, 'id_periode', 'id_periode');
    }

    public function pesertapelatihan():HasMany{
        return $this->hasMany(pesertapelatihanmodel::class);
    }

    public function pesertasertifikasi():HasMany{
        return $this->hasMany(pesertasertifikasimodel::class);
    }
}
