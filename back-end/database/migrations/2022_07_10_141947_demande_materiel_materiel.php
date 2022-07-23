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
        Schema::create('demande_materiel_materiel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_materiel_id');
            $table->foreignId('materiel_id');
            $table->foreign('demande_materiel_id')->references('id')->on('demande_materiels')
                ->onDelete('cascade');
            $table->foreign('materiel_id')->references('id')->on('materiels')
                ->onDelete('cascade');
            $table->integer('status')->default(0);
            $table->integer('quantity');
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
        Schema::dropIfExists('demande_materiel_materiel');
    }
};
