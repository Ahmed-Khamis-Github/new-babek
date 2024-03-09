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
        Schema::create('company_file_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('company_files')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses')
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
        Schema::dropIfExists('company_file_orders');
    }
};
