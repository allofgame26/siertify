<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class vendorsertifikasimodel extends Model
{
    use HasFactory;

    protected $table = 'm_vendor_sertifikasi';
    protected $primaryKey = 'id_vendor_sertifikasi';

    protected $fillable = ['nama_vendor_sertifikasi','alamat_vendor_pealtihan','kota_vendor_sertifikasi','notelp_vendor_sertifikasi','web_vendor_sertifikasi','web_vendor_sertifikasi'];

    public function sertifikasi():HasMany{
        return $this->hasMany(sertifikasimodel::class);
    }
}
