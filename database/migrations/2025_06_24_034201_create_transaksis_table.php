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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained();
            $table->foreignId('rekening_id')->nullable()->constrained(); // jika transfer
            $table->enum('metode_pembayaran', ['cod', 'transfer']);
            $table->string('kode_transaksi')->unique();
            $table->decimal('total', 12, 2)->default(0);       // Total belanja (belum termasuk ongkir)
            $table->decimal('ongkir', 12, 2)->default(0);      // Ongkos kirim
            $table->decimal('grand_total', 12, 2)->default(0); // total + ongkir
            $table->enum('status', ['baru', 'packing', 'pengiriman', 'diterima', 'dibatalkan'])->default('baru');
            $table->text('image_transfer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
