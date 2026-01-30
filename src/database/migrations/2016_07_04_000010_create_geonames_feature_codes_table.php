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
        Schema::connection(config('geonames.connection'))->create('geonames_feature_codes', function (Blueprint $table) {
            $table->string('code', 11)->primary();
            $table->string('name', 100);
            $table->string('description', 500);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('geonames.connection'))->dropIfExists('geonames_feature_codes');
    }
};
