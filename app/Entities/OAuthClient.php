<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class OAuthClient extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'oauth_clients';
    
    protected $fillable = [
        'id',
        'secret',
    	'name'
    ];
    
}
