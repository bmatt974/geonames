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
        Schema::connection(config('geonames.connection'))->create('geonames_alternate_names', function (Blueprint $table) {
            $table->integer('alternate_name_id')->primary()->unsigned();
            $table->integer('geoname_id')->index()->unsigned();
            $table->foreign('geoname_id')->references('geoname_id')->on('geonames_geonames')->onUpdate('cascade')->onDelete('cascade');
            $table->string('iso_language', 7)->nullable();
            $table->string('alternate_name', 400)->nullable();
            $table->boolean('is_preferred_name')->index();
            $table->boolean('is_short_name')->index();
            $table->boolean('is_colloquial');
            $table->boolean('is_historic');
            $table->string('from', 100)->nullable();
            $table->string('to', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('geonames.connection'))->dropIfExists('geonames_alternate_names');
    }
};
