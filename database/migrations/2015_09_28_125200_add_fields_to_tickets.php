<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('schedule')->after('content');
            $table->date('published_at')->after('schedule');
            $table->string('author')->after('published_at');
            $table->string('categories')->after('author');
            $table->string('article_title')->after('categories');
            $table->boolean('priority')->after('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('schedule');
            $table->dropColumn('published_at');
            $table->dropColumn('author');
            $table->dropColumn('categories');
            $table->dropColumn('article_title');
            $table->dropColumn('priority');
        });
    }
}
