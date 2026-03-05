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
        Schema::table('leveranciers', function (Blueprint $table) {
            $table->unsignedBigInteger('ContactId')->nullable()->after('Mobiel');
            $table->foreign('ContactId')->references('id')->on('contacts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leveranciers', function (Blueprint $table) {
            $table->dropForeign(['ContactId']);
            $table->dropColumn('ContactId');
        });
    }
};
