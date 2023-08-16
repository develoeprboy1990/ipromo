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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('CompanyID');
            $table->string('Name')->nullable();
            $table->string('Name2')->nullable();
            $table->string('TRN')->comment('tax registration no')->nullable();
            $table->string('Currency')->nullable();
            $table->string('Mobile')->nullable();
            $table->string('Contact')->nullable();
            $table->string('Email')->nullable();
            $table->string('Website')->nullable();
            $table->text('Address')->nullable();
            $table->string('Logo')->nullable();
            $table->string('BackgroundLogo')->nullable();
            $table->string('Signature')->nullable();
            $table->string('DigitalSignature')->nullable();
            $table->string('EstimateInvoiceTitle')->nullable();
            $table->string('SaleInvoiceTitle')->nullable();
            $table->string('DeliveryChallanTitle')->nullable();
            $table->string('CreditNoteTitle')->nullable();
            $table->string('PurchaseInvoiceTitle')->nullable();
            $table->string('DebitNoteTitle')->nullable();
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
        Schema::dropIfExists('companies');
    }
};
