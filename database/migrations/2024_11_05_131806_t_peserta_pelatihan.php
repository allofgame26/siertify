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
        Schema::create('t_peserta_pelatihan',function(Blueprint $table){
            $table->id('id_peserta');
            $table->unsignedBigInteger('id_user')->index();
            $table->unsignedBigInteger('id_detail_pelatihan')->index();

            $table->foreign('id_user')->references('id_user')->on('m_akun_user');
            $table->foreign('id_detail_pelatihan')->references('id_detail_pelatihan')->on('t_detailpelatihan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_peserta_pelatihan');
    }
};
