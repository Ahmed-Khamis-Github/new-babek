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
        Schema::create('employee_file_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
 
   

            $table->integer('company_id')->unsigned();

            $table->foreign('company_id')->references('id')->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->integer('employer_id')->unsigned();
            $table->foreign('employer_id')->references('id')->on('employer_files')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->string('file_name');
            $table->date('renewal_date');


            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            
            //$table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_file_orders');
    }
};
