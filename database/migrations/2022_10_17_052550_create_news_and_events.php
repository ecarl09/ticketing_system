<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsAndEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_and_events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->string('author', 50);
            $table->string('category', 15);
            $table->string('featuredImage', 15);
            $table->text('content');
            $table->string('isComment', 5);
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
        Schema::dropIfExists('news_and_events');
    }
}
