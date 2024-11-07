<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_vendor_sertifikasi', function(Blueprint $table){
            $table->id('id_vendor_sertifikasi');
            $table->string('nama_vendor_sertifikasi',50);
            $table->string('alamat_vendor_sertifikasi',255);
            $table->string('kota_vendor_sertifikasi',10);
            $table->string('notelp_vendor_sertifikasi',15);
            $table->string('web_vendor_sertifikasi',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_vendor_sertifikasi');
    }
};
