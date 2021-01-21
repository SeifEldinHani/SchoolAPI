<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('gradename');  
            $table->unsignedBigInteger("School_id");            
            $table->timestamps();
            $table->foreign("School_id")->references("id")->on("schools")->onDelete("cascade"); 
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
        Schema::dropIfExists('grades');
    }
}
