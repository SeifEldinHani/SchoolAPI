<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {


            $table->id();
            $table->timestamps();            


            
            $table->string("name");
            $table->string("sex");
            $table->integer("age");
            $table->unsignedBigInteger("classroom_id");
            $table->unsignedBigInteger("School_id"); 
            $table->unsignedBigInteger("grade_id"); 
            $table->unsignedBigInteger("parentt_id"); 
            $table->unsignedBigInteger("user_id"); 
            $table->foreign("classroom_id")->references("id")->on("classrooms")->onDelete("cascade"); 
            $table->foreign("School_id")->references("id")->on("schools")->onDelete("cascade"); 
            $table->foreign("grade_id")->references("id")->on("grades")->onDelete("cascade"); 
            $table->foreign("parentt_id")->references("id")->on("parentts")->onDelete("cascade"); 
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
        Schema::dropIfExists('students');
    }
}
