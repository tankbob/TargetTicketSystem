<?php

namespace TargetInk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $table = 'files';

    protected $fillable = [
    	'filename',
        'filepath',
    	'client_id',
    	'type'
    ];

    public function scopeSeo($query)
    {
        return $query->where('type', '=', 0);
    }

    public function scopeInformation($query)
    {
        return $query->where('type', '=', 1);
    }

    public function client(){
        return $this->belongsTo('TargetInk\User', 'client_id');
    }
}
