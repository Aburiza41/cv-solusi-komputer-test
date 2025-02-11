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
        Schema::create('trx_header', function (Blueprint $table) {
            // Nomor | Primary Key
            $table->string('nomor_trx')->unique();
            // Tanggal | Date
            $table->date('tanggal');
            // Kode Dinas | Foreign Key
            $table->foreignId('dinas');
            // Total | Decimal 15.000
            $table->string('total');
            $table->timestamps();
        });

        Schema::create('trx_detail', function (Blueprint $table) {
            // Nomor | Primary Key
            $table->string('nomor_trx');
            // Kode Dinas | Foreign Key
            $table->foreignId('dinas');
            $table->foreignId('kegiatan');
            // Kode Akun | Foreign Key
            $table->foreignId('akun');
            // Kode Nilai | Decimal 15.000
            $table->string('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_header');
        Schema::dropIfExists('trx_detail');
    }
};
