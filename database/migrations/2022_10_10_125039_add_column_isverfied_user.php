<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsverfiedUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()    {
        Schema::table('users', function (Blueprint $table){
            $table->string('isVerified', 50)->after('isFirstLogin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
