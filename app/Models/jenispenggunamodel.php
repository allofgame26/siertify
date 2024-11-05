<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class jenispenggunamodel extends Model
{
    use HasFactory;

    protected $table = 'm_jenis_pengguna';
    protected $primaryKey = 'idjjenis_pengguna';

    protected $fillable = ['nama_jenis_pengguna','kode_jenis_pengguna'];

    public function akun():HasMany{
        return $this->hasMany(akunusermodel::class);
    }
}
