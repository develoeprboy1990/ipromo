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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('controller_type')->nullable();
            $table->string('no_of_steps')->nullable();
            $table->string('overspeed_governer_voltage')->nullable();
            $table->string('brake_voltage')->nullable();
            $table->string('moter')->nullable();
            $table->string('encoder_type')->nullable();
            $table->string('no_of_entrance')->nullable();
            $table->string('resue')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('door_type')->nullable();
            $table->string('file')->nullable();
            $table->string('other_materials')->nullable();
            $table->text('additional_details')->nullable();
            $table->enum('status',['active','in-active'])->default('active');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
