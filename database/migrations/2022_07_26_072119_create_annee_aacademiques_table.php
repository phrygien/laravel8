<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnneeAacademiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annee_aacademiques', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('status')->default(0);
            $table->integer('user_add');
            $table->unsignedBigInteger('academique_id');
            $table->foreign('academique_id')->references('id')->on('academiques');
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
        Schema::dropIfExists('annee_aacademiques');
    }
}
