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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->index()->constrained();
            $table->string('kode_produk')->unique();
            $table->string('nama_produk');
            $table->string('brand')->nullable();
            $table->integer('price');
            $table->integer('cost_price');
            $table->integer('stock');
            // $table->string('unit');
            $table->text('description')->nullable();
            $table->float('discount')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
