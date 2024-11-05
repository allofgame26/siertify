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
        Schema::create('m_jenis_pelatihan_sertifikasi', function (Blueprint $table){
            $table->id('id_jenis_pelatihan_sertifikasi');
            $table->string('nama_jenis_setifikasi',20);
            $table->string('deskripsi_pendek',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_jenis_pelatihan_sertifikasi');
    }
};
