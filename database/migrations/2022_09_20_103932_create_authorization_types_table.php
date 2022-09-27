<?php

use App\Models\Authorization;
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
        Schema::create('authorization_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
        });

        if (Schema::hasTable('authorizations') && !(Schema::hasColumn('authorizations', 'authorization_type_id'))) {
            Schema::table('authorizations', function (Blueprint $table) {
                if (Schema::hasColumn('authorizations', 'role_id')) {
                    $table->foreignId('authorization_type_id')->after('role_id')->constrained('authorization_types');
                } else {
                    $table->foreignId('authorization_type_id')->after('id')->constrained('authorization_types');
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
        Schema::dropIfExists('authorization_types');
    }
};
