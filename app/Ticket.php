<?php

namespace TargetInk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $table = 'tickets';

    protected $fillable = [
    	'ref_no',
        'title',
        'client_id',
        'type',
        'archived',
        'order',
        'priority'
    ];

    public function Client(){
    	return $this->BelongsTo('TargetInk\User', 'client_id');
    }

    public function responses(){
        return $this->hasMany('TargetInk\Response', 'ticket_id');
    }

}