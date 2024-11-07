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
        Schema::create('m_vendor_pelatihan', function(Blueprint $table){
            $table->id('id_vendor_pelatihan');
            $table->string('nama_vendor_pelatihan',50);
            $table->string('alamat_vendor_pelatihan',255);
            $table->string('kota_vendor_pelatihan',10);
            $table->string('notelp_vendor_pelatihan',15);
            $table->string('web_vendor_pelatihan',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_vendor_pelatihan');
    }
};
