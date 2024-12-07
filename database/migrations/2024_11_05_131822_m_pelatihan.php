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
        Schema::create('m_pelatihan', function (Blueprint $table){
            $table->id('id_pelatihan');
            $table->string('nama_pelatihan',40);
            $table->unsignedBigInteger('id_vendor_pelatihan')->index();
            $table->unsignedBigInteger('id_jenis_pelatihan_sertifikasi')->index();
            $table->enum('level_pelatihan',['nasional','internasional']);
            $table->timestamps();

            $table->foreign('id_vendor_pelatihan')->references('id_vendor_pelatihan')->on('m_vendor_pelatihan');
            $table->foreign('id_jenis_pelatihan_sertifikasi')->references('id_jenis_pelatihan_sertifikasi')->on('m_jenis_pelatihan_sertifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_pelaihan');
    }
};
