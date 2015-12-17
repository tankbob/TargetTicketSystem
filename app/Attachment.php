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

    public function getFilename()
    {
        if($this->original_filename) {
            return $this->original_filename;
        } elseif($this->filename) {
            return $this->filename;
        } else {
            return 'File #' . $this->id;
        }
    }
}
