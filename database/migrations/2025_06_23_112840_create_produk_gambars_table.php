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
        Schema::create('produk_gambars', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk');
            $table->string('gambar');
            $table->timestamps();

            $table->foreign('kode_produk')
                ->references('kode_produk')
                ->on('produks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_gambars');
    }
};
