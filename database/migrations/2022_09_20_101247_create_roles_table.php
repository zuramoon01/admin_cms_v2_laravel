<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
        });

        if (Schema::hasTable('admins') && !(Schema::hasColumn('admins', 'role_id'))) {
            Schema::table('admins', function (Blueprint $table) {
                $table->foreignId('role_id')->after('id')->constrained('roles');
            });
        }

        if (Schema::hasTable('authorizations') && !(Schema::hasColumn('authorizations', 'role_id'))) {
            Schema::table('authorizations', function (Blueprint $table) {
                $table->foreignId('role_id')->after('id')->constrained('roles');
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
        Schema::dropIfExists('roles');
    }
};
