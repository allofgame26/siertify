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
        Schema::create('t_tagging_bd_sertifikasi', function (Blueprint $table){
            $table->id('id_tagging_bd');
            $table->unsignedBigInteger('id_sertifikasi')->index();
            $table->unsignedBigInteger('id_bd')->index();
            $table->timestamps();
            
            $table->foreign('id_sertifikasi')->references('id_sertifikasi')->on('m_sertifikasi');
            $table->foreign('id_bd')->references('id_bd')->on('m_bidang_minat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_tagging_bd_sertifikasi');
    }
};
