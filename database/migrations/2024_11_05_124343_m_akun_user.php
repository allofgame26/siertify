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
        Schema::create('m_akun_user', function (Blueprint $table){
            $table->id('id_user');
            $table->unsignedBigInteger('id_identitas')->index();
            $table->unsignedBigInteger('id_jenis_pengguna')->index();
            $table->unsignedBigInteger('id_periode')->index();
            $table->string('username',20);
            $table->string('password',255);
            $table->timestamps();

            $table->foreign('id_identitas')->references('id_identitas')->on('m_identitas_diri');
            $table->foreign('id_jenis_pengguna')->references('id_jenis_pengguna')->on('m_jenis_pengguna');
            $table->foreign('id_periode')->references('id_periode')->on('m_periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_akun_user');
    }
};
