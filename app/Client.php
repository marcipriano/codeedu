<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'name',
    	'responsable',
    	'email',
    	'phone',
    	'address',
    	'obs'
    ];
}
