<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('job_id')->nullable();
            $table->enum('status',['pending','in-progress','reviewed','completed'])->default('pending');
            $table->longText('reply')->nullable();

            $table->foreign('user_id')->references('UserID')->on('user')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_jobs');
    }
};
