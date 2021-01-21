<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("sex");
            $table->integer("age");
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
        Schema::dropIfExists('teachers');
    }
}
