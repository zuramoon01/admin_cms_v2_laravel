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
        Schema::create('voucher_usages', function (Blueprint $table) {
            $table->id();
            if (Schema::hasTable('transactions') && !Schema::hasColumn('voucher_usages', 'transactions_id')) {
                $table->foreignId('transactions_id')->constrained('transactions');
            }
            if (Schema::hasTable('vouchers') && !Schema::hasColumn('voucher_usages', 'vouchers_id')) {
                $table->foreignId('vouchers_id')->constrained('vouchers');
            }
            $table->decimal('discounted_value', $precision = 18);
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
        Schema::dropIfExists('voucher_usages');
    }
};
