<?php

namespace TargetInk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $table = 'tickets';

    protected $fillable = [
        'title',
        'client_id',
        'type',
        'archived',
        'order',
        'priority',
        'cost'
    ];

    public function client(){
    	return $this->BelongsTo('TargetInk\User', 'client_id');
    }

    public function responses(){
        return $this->hasMany('TargetInk\Response', 'ticket_id');
    }

    public function totalTime(){
        $totalTime = $this->responses->sum('working_time');
        return str_pad(floor($totalTime/60), 2, 0, STR_PAD_LEFT).':'.str_pad($totalTime%60, 2, 0, STR_PAD_LEFT);
    }

}