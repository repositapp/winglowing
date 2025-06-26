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
        Schema::create('ongkirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->index()->constrained();
            $table->foreignId('district_id')->index()->constrained();
            $table->foreignId('village_id')->index()->constrained();
            $table->decimal('biaya', 10, 2); // biaya ongkir
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ongkirs');
    }
};
