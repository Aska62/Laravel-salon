<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReCreatePaymentsTable extends Migration
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
            $table->integer('amount')->comment('支払額')->nullable(false);
            $table->foreignId('user_id')
                ->comment('ユーザーID')
                ->nullable(false)
                ->constrained('users');
            $table->foreignId('salon_id')
                ->comment('サロンID')
                ->nullable(false)
                ->constrained('salons');
            $table->integer('payment_for')->comment('該当年月')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
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
}
