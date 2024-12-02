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
        Schema::create('t_detailsertifikasi', function (Blueprint $table){
            $table->id('id_detail_sertifikasi');
            $table->unsignedBigInteger('id_sertifikasi')->index();
            $table->unsignedBigInteger('id_periode')->index();
            $table->unsignedBigInteger('id_user')->index();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('lokasi',50);
            $table->string('quota_peserta',5);
            $table->integer('biaya');
            $table->string('no_sertifikasi',20);
            $table->string('bukti_sertifikasi',255);
            $table->date('tanggal_kadaluarsa');
            $table->enum('status_disetujui',['iya','tidak']);
            $table->enum('input_by',['admin','dosen']);
            $table->timestamps();

            $table->foreign('id_sertifikasi')->references('id_sertifikasi')->on('m_sertifikasi');
            $table->foreign('id_periode')->references('id_periode')->on('m_periode');
            $table->foreign('id_user')->references('id_user')->on('m_akun_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_detailsertifikasi');
    }
};
