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
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('lender_id');
            $table->foreignUuid('barrower_id');
            $table->string('loan_amount');
            $table->string('terms');
            $table->string('term_unit');
            $table->string('monthly_payment');
            $table->string('status');
            $table->boolean('approved_by_lender');
            $table->boolean('approved_by_barrower');
            $table->foreignUuid('created_by');
            $table->dateTime('release_date')->nullable();
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
        Schema::dropIfExists('loan_applications');
    }
};
