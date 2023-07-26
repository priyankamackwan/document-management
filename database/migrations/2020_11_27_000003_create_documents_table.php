<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('policy_number')->nullable();
            $table->string('policy_owner');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('maturity_date')->nullable();
            $table->decimal('maturity_amount', 15, 2)->nullable();
            $table->longText('description')->nullable();
            $table->decimal('premium_payment_amount', 15, 2)->nullable();
            $table->string('premium_payment_duration')->nullable();
            $table->string('is_reminder')->nullable();
            $table->string('policy_purchased_from')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
