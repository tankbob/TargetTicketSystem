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
}
