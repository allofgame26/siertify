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
        Schema::create('t_notifikasi_user', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('id_user')->index();; // Foreign Key ke tabel m_akun_user
            $table->string('pesan'); // Kolom untuk menyimpan pesan t_notifikasi_user
            $table->boolean('is_read')->default(false); // Status read (default: false)
            $table->timestamps(); // Kolom created_at dan updated_at

            // Foreign Key Constraint
            $table->foreign('id_user')->references('id_user')->on('m_akun_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_notifikasi_user');
    }
};
