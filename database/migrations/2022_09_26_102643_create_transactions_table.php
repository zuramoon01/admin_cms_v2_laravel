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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 50)->unique();
            $table->string('customer_name', 200);
            $table->string('customer_email', 100);
            $table->string('customer_phone', 45)->nullable();
            $table->decimal('sub_total', $precision = 18);
            $table->decimal('total', $precision = 18);
            $table->decimal('total_purchase', $precision = 18);
            $table->text('additional_request')->nullable();
            $table->string('payment_method', 200);
            $table->unsignedTinyInteger('status');
            $table->timestamps();
        });

        if (Schema::hasTable('transaction_details') && !Schema::hasColumn('transaction_details', 'transaction_id')) {
            Schema::table('transaction_details', function (Blueprint $table) {
                $table->foreignId('products_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
