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
        Schema::connection(config('geonames.connection'))->create('geonames_geonames', function (Blueprint $table) {
            $table->integer('geoname_id')->primary()->unsigned();
            $table->string('name', 200);
            $table->string('ascii_name', 200)->nullable();
            $table->string('alternate_names', 10000)->nullable();
            $table->decimal('latitude', 7, 5);
            $table->decimal('longitude', 8, 5);
            $table->char('feature_class', 1)->nullable();
            $table->string('feature_code', 10)->nullable();
            $table->char('country_code', 2);
            $table->string('cc2', 200)->nullable();
            $table->string('admin1_code', 20)->nullable();
            $table->string('admin2_code', 80)->nullable();
            $table->string('admin3_code', 20)->nullable();
            $table->string('admin4_code', 20)->nullable();
            $table->bigInteger('population')->unsigned()->nullable();
            $table->integer('elevation')->nullable();
            $table->integer('dem')->nullable();
            $table->string('timezone_id', 40)->index()->nullable();
            $table->foreign('timezone_id')->references('timezone_id')->on('geonames_timezones')->onUpdate('cascade')->onDelete('cascade');
            $table->date('modified_at');

            $table->index(['country_code', 'admin1_code']);
            $table->index(['feature_class', 'feature_code']);
            $table->index(['ascii_name', 'feature_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('geonames.connection'))->dropIfExists('geonames_geonames');
    }
};
