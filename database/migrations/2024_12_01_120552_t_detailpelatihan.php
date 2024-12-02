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
        Schema::create('t_detailpelatihan', function (Blueprint $table){
            $table->id('id_detail_pelatihan');
            $table->unsignedBigInteger('id_pelatihan')->index();
            $table->unsignedBigInteger('id_periode')->index();
            $table->unsignedBigInteger('id_user')->index();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('lokasi',50);
            $table->string('quota_peserta',5);
            $table->integer('biaya');
            $table->string('no_pelatihan',20);
            $table->string('bukti_pelatihan',255);
            $table->enum('status_disetujui',['iya','tidak']);
            $table->enum('input_by',['admin','dosen']);
            $table->timestamps();

            $table->foreign('id_pelatihan')->references('id_pelatihan')->on('m_pelatihan');
            $table->foreign('id_periode')->references('id_periode')->on('m_periode');
            $table->foreign('id_user')->references('id_user')->on('m_akun_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_detailpelatihan');
    }
};
