<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camp_benefits', function (Blueprint $table) {
            $table->id();
            // cara 1 relasi
            //$table->bigInteger('camps_id')->unsigned();
            //$table->unsignedBigInteger('camps_id');
            $table->foreignId('camp_id')->constrained();
            $table->string('name');
            $table->timestamps();

            // relasi table
            //$table->foreign('camps_id')->references('id')->on('camps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camp_benefits');
    }
}
