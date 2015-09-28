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
        'content',
        'client_id',
        'type',
        'cost',
        'archived',
        'order',
        'schedule',
        'published_at',
        'author',
        'categories',
        'article_title',
        'priority'
    ];

    public function Client(){
    	return $this->BelongsTo('TargetInk\User', 'client_id');
    }

}