<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Project extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
    	'name',
    	'description',
    	'progress',
    	'client_id',
    	'owner_id',
    	'staus',
    	'due_date'
	];

    public function owner()
    {
        return $this->belongsTo('App\Entities\User', 'owner_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Entities\Client', 'client_id');
    }
}
