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
        Schema::create('returns_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stake_holder_id')->nullable();
            $table->foreign('stake_holder_id')->references('id')->on('stake_holders')->onDelete('Cascade');
            $table->unsignedBigInteger('r_invoice_id')->nullable();
            $table->foreign('r_invoice_id')->references('id')->on('returns')->onDelete('Cascade');
            $table->double('value'); // 100000
            $table->enum('type_return',['sale','purchasing'])->default('sale');
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
        Schema::dropIfExists('returns_payments');
    }
};
