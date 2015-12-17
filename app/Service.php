<?php

namespace TargetInk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{

	use SoftDeletes;

    protected $table = 'services';

	protected $fillable = [
		'id',
		'client_id',
		'heading',
		'link',
		'text',
		'icon',
		'icon_rollover'
	];

	public function client()
	{
        return $this->belongsTo('TargetInk\User', 'client_id');
    }

}
