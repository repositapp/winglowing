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
        Schema::create('biodatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained();
            $table->string('nama_lengkap');
            $table->foreignId('city_id')->index()->constrained();
            $table->foreignId('district_id')->index()->constrained();
            $table->foreignId('village_id')->index()->constrained();
            $table->text('alamat')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('telepon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodatas');
    }
};
