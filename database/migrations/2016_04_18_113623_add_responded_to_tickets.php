<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use TargetInk\Ticket;

class AddRespondedToTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->boolean('responded')->after('archived');
        });

        foreach(Ticket::all() as $ticket){
            $ticket->responded = @$ticket->responses->last()->admin;
            $ticket->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('responded');
        });
    }
}
