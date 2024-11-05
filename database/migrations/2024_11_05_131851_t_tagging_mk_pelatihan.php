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
        Schema::create('t_tagging_mk_pelatihan', function (Blueprint $table){
            $table->id('id_tagging_mk');
            $table->unsignedBigInteger('id_pelatihan')->index();
            $table->unsignedBigInteger('id_mk')->index();
            $table->timestamps();
            
            $table->foreign('id_pelatihan')->references('id_pelatihan')->on('m_pelatihan');
            $table->foreign('id_mk')->references('id_mk')->on('m_mata_kuliah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_tagging_mk_pelatihan');
    }
};
