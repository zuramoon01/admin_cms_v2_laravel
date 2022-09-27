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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            if (Schema::hasTable('product_categories') && !Schema::hasColumn('products', 'product_categories_id')) {
                $table->foreignId('product_categories_id')->constrained('product_categories');
            }
            $table->string('name', 200);
            $table->string('code', 50);
            $table->decimal('price', $precision = 18);
            $table->decimal('purchase_price', $precision = 18);
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('new_product');
            $table->unsignedTinyInteger('best_seller');
            $table->unsignedTinyInteger('featured');
            $table->timestamps();
        });

        if (Schema::hasTable('transaction_details') && !Schema::hasColumn('transaction_details', 'products_id')) {
            Schema::table('transaction_details', function (Blueprint $table) {
                if (Schema::hasColumn('transaction_datails', 'transactions_id')) {
                    $table->foreignId('products_id')->after('transactions_id')->constrained('products');
                } else {
                    $table->foreignId('products_id')->constrained('products');
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
        Schema::dropIfExists('products');
    }
};
