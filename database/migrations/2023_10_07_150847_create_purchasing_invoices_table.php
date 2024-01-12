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
        Schema::create('purchasing_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable();
            $table->integer('quantity');
            $table->double('total_price',8, 2);
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('stake_holders')->onDelete('set null');
            $table->enum('payment_type', ['cashe', 'postponed'])->default('cashe');
            $table->enum('update_stock',['0','1'])->default('0');
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
        Schema::dropIfExists('purchasing_invoices');
    }
};
