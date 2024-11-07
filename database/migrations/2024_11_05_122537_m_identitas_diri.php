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
        Schema::create('m_identitas_diri',function (Blueprint $table) {
            $table->id('id_identitas');
            $table->string('nama_lengkap',100);
            $table->string('NIP',20)->unique();
            $table->string('tempat_lahir',20);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin',['laki','perempuan']);
            $table->string('alamat',100);
            $table->string('no_telp',15);
            $table->string('email',50);
            $table->string('foto_profil',255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_identitas_diri');
    }
};
