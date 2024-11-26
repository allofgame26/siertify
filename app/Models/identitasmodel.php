<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class identitasmodel extends Model
{
    use HasFactory;

    protected $table = 'm_identitas_diri';
    protected $primaryKey = 'id_identitas';

    protected $fillable = ['nama_lengkap','NIP','tempat_lahir','tanggal_lahir','jenis_kelamin','alamat','no_telp','email','foto_profil'];

    public function akun():HasMany{
        return $this->hasMany(akunusermodel::class);
    }

    protected function foto_profil(): Attribute{
        return Attribute::make(
            get: fn ($foto_profil) => url('/img/' . $foto_profil),
        );
    }

}
