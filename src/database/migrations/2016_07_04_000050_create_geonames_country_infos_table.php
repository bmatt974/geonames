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
        Schema::connection(config('geonames.connection'))->create('geonames_country_infos', function (Blueprint $table) {
            $table->char('iso', 2)->unique();
            $table->char('iso3', 3)->unique();
            $table->char('iso_numeric', 3)->unique();
            $table->char('fips', 2)->nullable();
            $table->string('country', 60);
            $table->string('capital', 40);
            $table->integer('area')->unsigned();
            $table->integer('population')->unsigned()->nullable();
            $table->char('continent_code', 2);
            $table->integer('continent_id')->unsigned();
            $table->foreign('continent_id')->references('geoname_id')->on('geonames_geonames')->onUpdate('cascade')->onDelete('cascade');
            $table->char('tld', 3)->nullable();
            $table->char('currency_code', 3)->nullable();
            $table->string('currency_name', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('postal_code_format', 100)->nullable();
            $table->string('postal_code_regex', 200)->nullable();
            $table->string('languages', 100)->nullable();
            $table->integer('geoname_id')->primary()->unsigned();
            $table->foreign('geoname_id')->references('geoname_id')->on('geonames_geonames')->onUpdate('cascade')->onDelete('cascade');
            $table->string('neighbors', 60)->nullable();
            $table->char('equivalent_fips_code', 2)->nullable();
        });

        // Now can add the foreign key constraint to timezones table also
        Schema::connection(config('geonames.connection'))->table('geonames_timezones', function (Blueprint $table) {
            $table->foreign('country_code')->references('iso')->on('geonames_country_infos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First drop the foreign constraint from timezones table
        Schema::connection(config('geonames.connection'))->table('geonames_timezones', function (Blueprint $table) {
            $table->dropForeign('geonames_timezones_country_code_foreign');
        });
        Schema::connection(config('geonames.connection'))->dropIfExists('geonames_country_infos');
    }
};
