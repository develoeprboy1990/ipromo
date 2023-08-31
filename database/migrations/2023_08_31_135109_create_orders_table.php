<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('OfferID')->default(0);
            $table->integer('CustomerID')->default(0);
            $table->integer('product_id')->default(0);
            $table->text('description')->nullable();
            $table->string('payment_status')->nullable();
            $table->text('payment_description')->nullable();
            $table->text('payment_message')->nullable();
            $table->text('log_record')->nullable();
            $table->decimal('subtotalprice', 22)->nullable()->default(0.00);
            $table->decimal('totalprice', 22)->nullable()->default(0.00);
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
        Schema::dropIfExists('orders');
    }
}
