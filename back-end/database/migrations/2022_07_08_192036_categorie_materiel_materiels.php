<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorie_materiel_materiel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_materiel_id');
            $table->foreign('categorie_materiel_id')->references('id')->on('categorie_materiels')
                ->onDelete('cascade');
            $table->foreignId('materiel_id');
            $table->foreign('materiel_id')->references('id')->on('materiels')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_materiel_materiel');
    }
};
