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
        Schema::create('aplikasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko');
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->text('alamat')->nullable();
            $table->text('maps')->nullable();
            $table->string('nama_pemilik')->nullable();
            $table->string('sidebar_lg');
            $table->string('sidebar_mini');
            $table->string('title_header');
            $table->text('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplikasis');
    }
};
