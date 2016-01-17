<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'name',
    	'responsible',
    	'email',
    	'phone',
    	'address',
    	'obs'
    ];

    public function project()
    {
        return $this->hasMany('App\Entities\Project');
    }
    
}
