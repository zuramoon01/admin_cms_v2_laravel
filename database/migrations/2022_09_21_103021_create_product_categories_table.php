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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category', 100);
            $table->text('description')->nullable();
        });

        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'product_categories_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('product_categories_id')->after('id')->constrained('product_categories');
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
        Schema::dropIfExists('product_categories');
    }
};
