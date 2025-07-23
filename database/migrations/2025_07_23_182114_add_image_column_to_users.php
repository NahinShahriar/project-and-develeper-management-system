<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the column only if it does not exist
            if (!Schema::hasColumn('users', 'images')) {
                $table->string('images')->default('default_profile.jpg');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the column if it exists
            if (Schema::hasColumn('users', 'images')) {
                $table->dropColumn('images');
            }
        });
    }
}
