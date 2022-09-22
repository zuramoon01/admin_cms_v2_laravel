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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('icon', 50)->default('table');
            $table->string('route', 50)->unique();
            $table->string('slug', 50)->unique();
        });

        if (Schema::hasTable('authorizations') && !(Schema::hasColumn('authorizations', 'menu_id'))) {
            Schema::table('authorizations', function (Blueprint $table) {
                if (Schema::hasColumn('authorizations', 'authorization_type_id')) {
                    $table->foreignId('menu_id')->after('authorization_type_id')->constrained('menus');
                } else if (Schema::hasColumn('authorizations', 'role_id')) {
                    $table->foreignId('menu_id')->after('role_id')->constrained('menus');
                } else {
                    $table->foreignId('menu_id')->constrained('menus');
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
        Schema::dropIfExists('menus');
    }
};
