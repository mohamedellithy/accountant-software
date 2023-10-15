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
        Schema::create('total__payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stake_holder_id')->nullable();
            $table->foreign('stake_holder_id')->references('id')->on('stake_holders')->onDelete('Cascade');
            $table->double('value');
            $table->double('debit',2); // المدين => destination  // purchasing invoices // -
            $table->double('credit',2); //  الدائن =>source // order invoices // +

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
        Schema::dropIfExists('total__payments');
    }
};
