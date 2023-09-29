<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('name');

            $table->string('gender', 50);
            $table->date('birthday')->after('gender')->nullable();
            $table->string('civilStatus', 255)->after('birthday');
            $table->string('chapterName', 255)->after('civilStatus');
            $table->string('position', 255)->after('chapterName');
            $table->string('userType', 50)->after('position');
            $table->string('userStatus', 10)->after('userType');
            $table->string('number', 50);
            $table->string('firstName', 255);
            $table->string('middleName', 255);
            $table->string('lastName', 255);
            $table->text('address');
            $table->string('userCategory', 255);
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
