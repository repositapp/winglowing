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
        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->index()->constrained();
            $table->string('kode_transaksi');
            $table->integer('qty');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            $table->foreign('kode_transaksi')
                ->references('kode_transaksi')
                ->on('transaksis')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_details');
    }
};
