<?php

namespace TargetInk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use SoftDeletes;

    protected $table = 'responses';

    protected $fillable = [
		'id',
		'ticket_id',
		'admin',
		'working_time',
		'content',
        'cost',
        'schedule',
        'published_at',
        'author',
        'categories',
        'article_title'
    ];

    public function ticket(){
        return $this->belongsTo('TargetInk\Ticket', 'ticket_id');
    }

    public function attachments(){
        return $this->hasMany('TargetInk\Attachment', 'response_id');
    }

    public function formatWorkingTime(){
        return str_pad(floor($this->working_time/60), 2, 0, STR_PAD_LEFT).':'.str_pad($this->working_time%60, 2, 0, STR_PAD_LEFT);
    }
}
