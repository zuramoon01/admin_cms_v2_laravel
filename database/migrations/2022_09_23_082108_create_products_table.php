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
            $table->unsignedTinyInteger('status', 1);
            $table->unsignedTinyInteger('new_product', 1);
            $table->unsignedTinyInteger('best_seller', 1);
            $table->unsignedTinyInteger('featured', 1);
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
        Schema::dropIfExists('products');
    }
};
