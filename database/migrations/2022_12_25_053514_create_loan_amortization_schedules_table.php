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
        Schema::create('loan_amortization_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_application_id');
            $table->string('reference_number')->nullable();
            $table->date('date_of_payment');
            $table->string('beginning_balance');
            $table->string('scheduled_payment');
            $table->string('interest')->default('0');
            $table->string('pricipal')->default('0');
            $table->string('balance');
            $table->string('status');
            $table->softDeletes();
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
        Schema::dropIfExists('loan_amortization_schedules');
    }
};
