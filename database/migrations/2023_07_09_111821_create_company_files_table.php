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
        Schema::create('company_files', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('filename');
          $table->integer('company_id')->unsigned();
       

          $table->foreign('company_id')->references('id')->on('companies')
              ->onUpdate('cascade')
              ->onDelete('cascade');

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
        Schema::dropIfExists('company_files');
    }
};
