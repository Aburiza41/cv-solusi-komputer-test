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
        Schema::create('akun_1', function (Blueprint $table) {
            $table->decimal('kode', 1, 0)->unique();
            $table->longText('nama');
            $table->timestamps();
        });

        Schema::create('akun_2', function (Blueprint $table) {
            $table->decimal('kode', 2, 0)->unique();
            $table->longText('nama');
            $table->timestamps();
        });

        Schema::create('akun_3', function (Blueprint $table) {
            $table->decimal('kode', 4, 0)->unique();
            $table->longText('nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_1');
        Schema::dropIfExists('akun_2');
        Schema::dropIfExists('akun_3');
    }
};
