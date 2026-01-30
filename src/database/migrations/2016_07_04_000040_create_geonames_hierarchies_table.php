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
        Schema::connection(config('geonames.connection'))->create('geonames_hierarchies', function (Blueprint $table) {
            $table->integer('parent_id')->index()->unsigned();
            $table->foreign('parent_id')->references('geoname_id')->on('geonames_geonames')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('child_id')->index()->unsigned();
            $table->foreign('child_id')->references('geoname_id')->on('geonames_geonames')->onUpdate('cascade')->onDelete('cascade');
            $table->string('type', 40)->index();
            $table->unique(['parent_id', 'child_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('geonames.connection'))->dropIfExists('geonames_hierarchies');
    }
};
