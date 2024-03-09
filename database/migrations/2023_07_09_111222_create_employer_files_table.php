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
        Schema::create('employer_files', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('employer_id')->unsigned();

          $table->foreign('employer_id')->references('id')->on('employers')
              ->onUpdate('cascade')
              ->onDelete('cascade');
          
            
          $table->string('name');

          $table->string('filename');

          $table->date('start_date');
          $table->date('end_date');
          $table->softDeletes();

          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_files');
    }
};
