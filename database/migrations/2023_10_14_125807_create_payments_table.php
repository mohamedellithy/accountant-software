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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stake_holder_id')->nullable();
            $table->foreign('stake_holder_id')->references('id')->on('stake_holders')->onDelete('Cascade');
            $table->double('value'); // 100000 + 100000
            $table->double('paid',2); // مدفوع
            $table->double('unpaid',2); // غير مدفوع
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
        Schema::dropIfExists('payments');
    }
};
