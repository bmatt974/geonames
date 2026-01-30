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
        Schema::connection(config('geonames.connection'))->create('geonames_iso_language_codes', function (Blueprint $table) {
            $table->char('iso_639_3', 3)->primary();
            $table->char('iso_639_2', 3)->unique()->nullable();
            $table->char('iso_639_1', 2)->unique()->nullable();
            $table->string('language_name', 200);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('geonames.connection'))->dropIfExists('geonames_iso_language_codes');
    }
};
