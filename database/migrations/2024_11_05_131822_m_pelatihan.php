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
            $table->unsignedBigInteger('id_periode')->index();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('level_pelatihan',['nasional','internasional']);
            $table->string('lokasi',20);
            $table->string('biaya',15);
            $table->integer('quota_peserta');
            $table->string('no_pelatihan',20);
            $table->string('bukti_pelatihan',255);
            $table->enum('status_disetujui',['iya','tidak']);
            $table->enum('input_by',['admin','dosen']);
            $table->timestamps();

            $table->foreign('id_vendor_pelatihan')->references('id_vendor_pelatihan')->on('m_vendor_pelatihan');
            $table->foreign('id_jenis_pelatihan_sertifikasi')->references('id_jenis_pelatihan_sertifikasi')->on('m_jenis_pelatihan_sertifikasi');
            $table->foreign('id_periode')->references('id_periode')->on('m_periode');
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
