<?php

namespace TargetInk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
     use SoftDeletes;

    protected $table = 'attachments';

    protected $fillable = [
    	'response_id',
    	'original_filename',
    	'filename',
        'type'
    ];
}
