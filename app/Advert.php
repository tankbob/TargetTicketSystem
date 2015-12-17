<?php

namespace TargetInk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advert extends Model
{
    use SoftDeletes;

    protected $table = 'adverts';

    protected $fillable = [
    	'name',
        'image',
    	'client_id',
        'url'
    ];

    public function client()
    {
        return $this->belongsTo('TargetInk\User', 'client_id');
    }
}
