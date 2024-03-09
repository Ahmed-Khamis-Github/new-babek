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
        Schema::create('employers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ar_name');
            $table->string('en_name');
            $table->string('email');
            $table->string('phone');
            $table->string('gender');  
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');     
            $table->integer('job_title_id')->unsigned();


            $table->integer('nationality_id')->unsigned();

            $table->foreign('nationality_id')->references('id')->on('nationalities')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            

                  
            $table->foreign('job_title_id')->references('id')->on('job_titles')
            ->onUpdate('cascade')
            ->onDelete('cascade');
           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
