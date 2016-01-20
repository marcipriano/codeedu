<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

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
        return $this->hasMany(Project::class);
    }
    
}
