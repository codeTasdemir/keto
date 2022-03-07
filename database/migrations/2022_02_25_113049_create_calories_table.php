<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaloriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calories', function (Blueprint $table) {
            $table->id();
            $table->string('food');
            $table->float('carbohydrate');
            $table->float('protein');
            $table->float('fat');
            $table->integer('calorie');
            $table->integer('amount');
            $table->string('unit','10');
            $table->integer('min');
            $table->integer('max');
            $table->json('meal');
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
        Schema::dropIfExists('calories');
    }
}
