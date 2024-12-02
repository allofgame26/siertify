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
        Schema::create('m_sertifikasi', function (Blueprint $table){
            $table->id('id_sertifikasi');
            $table->string('nama_sertifikasi',40);
            $table->unsignedBigInteger('id_vendor_sertifikasi')->index();
            $table->unsignedBigInteger('id_jenis_pelatihan_sertifikasi')->index();
            $table->enum('level_sertifikasi',['nasional','internasional']);
            $table->timestamps();

            $table->foreign('id_vendor_sertifikasi')->references('id_vendor_sertifikasi')->on('m_vendor_sertifikasi');
            $table->foreign('id_jenis_pelatihan_sertifikasi')->references('id_jenis_pelatihan_sertifikasi')->on('m_jenis_pelatihan_sertifikasi');
            $table->foreign('id_periode')->references('id_periode')->on('m_periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_sertifikasi');
    }
};
