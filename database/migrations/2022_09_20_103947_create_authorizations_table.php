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
        Schema::create('authorizations', function (Blueprint $table) {
            $table->id();
            if (Schema::hasTable('roles') && !(Schema::hasColumn('authorizations', 'role_id'))) {
                $table->foreignId('role_id')->constrained('roles');
            }
            if (Schema::hasTable('authorization_types') && !(Schema::hasColumn('authorizations', 'authorization_type_id'))) {
                $table->foreignId('authorization_type_id')->constrained('authorization_types');
            }
            if (Schema::hasTable('menus') && !(Schema::hasColumn('authorizations', 'menu_id'))) {
                $table->foreignId('menu_id')->constrained('menus');
            }
            $table->boolean('has_access')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authorizations');
    }
};
