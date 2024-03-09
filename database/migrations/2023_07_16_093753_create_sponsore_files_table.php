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
        Schema::create('sponsore_files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sponsore_id')->unsigned();

            $table->foreign('sponsore_id')->references('id')->on('sponsores')
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
        Schema::dropIfExists('sponsore_files');
    }
};
