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
        Schema::create('m_detailmkdosen',function (Blueprint $table){
            $table->id('id_detailmk');
            $table->unsignedBigInteger('id_user')->index();
            $table->unsignedBigInteger('id_mk')->index();

            $table->foreign('id_user')->references('id_user')->on('m_akun_user');
            $table->foreign('id_mk')->references('id_mk')->on('m_mata_kuliah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_detailmkdosen');
    }
};
