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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->unsignedTinyInteger('type');
            $table->decimal('disc_value', $precision = 18);
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedTinyInteger('status');
            $table->timestamps();
        });

        if (Schema::hasTable('voucher_usages') && !Schema::hasColumn('voucher_usages', 'vouchers_id')) {
            Schema::table('voucher_usages', function (Blueprint $table) {
                if (Schema::hasColumn('voucher_usages', 'transactions_id')) {
                    $table->foreignId('vouchers_id')->after('transactions_id')->constrained('vouchers');
                } else {
                    $table->foreignId('vouchers_id')->after('id')->constrained('vouchers');
                }
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
        Schema::dropIfExists('vouchers');
    }
};
