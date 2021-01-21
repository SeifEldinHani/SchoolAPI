<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Null_;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('classname'); 
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('School_id');
            $table->timestamps();
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade'); 
            $table->foreign('School_id')->references('id')->on('schools')->onDelete('cascade'); 
            $table->unsignedBigInteger("user_id"); 
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade"); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
}
