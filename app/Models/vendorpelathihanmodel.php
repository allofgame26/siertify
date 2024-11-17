<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class vendorpelathihanmodel extends Model
{
    use HasFactory;

    protected $table = 'm_vendor_pelatihan';
    protected $primaryKey = 'id_vendor_pelatihan';

    protected $fillable = ['nama_vendor_pelatihan','alamat_vendor_pelatihan','kota_vendor_pelatihan','notelp_vendor_pelatihan','web_vendor_pelatihan'];

    public function pelatihan():HasMany{
        return $this->hasMany(pelatihanmodel::class);
    }
}
