<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveFieldsFromTicketsToResponse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropColumn('schedule');
            $table->dropColumn('author');
            $table->dropColumn('published_at');
            $table->dropColumn('categories');
            $table->dropColumn('article_title');
            $table->dropColumn('cost');
        });
        Schema::table('responses', function (Blueprint $table) {
            $table->string('schedule')->after('content');
            $table->string('author')->after('content');
            $table->date('published_at')->after('content');
            $table->string('categories')->after('content');
            $table->string('article_title')->after('content');
            $table->string('cost')->after('content');
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
            $table->text('content');
            $table->string('schedule');
            $table->string('author');
            $table->date('published_at');
            $table->string('categories');
            $table->string('article_title');
            $table->string('cost');
        });
        Schema::table('responses', function (Blueprint $table) {
            $table->dropColumn('schedule');
            $table->dropColumn('author');
            $table->dropColumn('published_at');
            $table->dropColumn('categories');
            $table->dropColumn('article_title');
            $table->dropColumn('cost');
        });
    }
}
