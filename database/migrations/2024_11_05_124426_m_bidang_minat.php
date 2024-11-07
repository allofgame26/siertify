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
        Schema::create('m_bidang_minat', function (Blueprint $table){
            $table->id('id_bd');
            $table->string('nama_bd',50);
            $table->string('kode_bd',10);
            $table->string('deskripsi_bd',255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_bidang_minat');
    }
};
