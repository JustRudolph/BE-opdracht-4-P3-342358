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
        Schema::create('product_per_leveranciers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('LeverancierId')->constrained('leveranciers')->onDelete('cascade');
            $table->foreignId('ProductId')->constrained('products')->onDelete('cascade');
            $table->date('DatumLevering');
            $table->integer('Aantal');
            $table->date('DatumEerstVolgendeLevering')->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_per_leveranciers');
    }
};
