<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model implements Transformable
{
    use SoftDeletes;
    use TransformableTrait;

    protected $fillable = [
    	'owner_id',
        'client_id',
        'name',
        'description',
        'progress',
    	'staus',
    	'due_date'
	];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'member_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }


    public function notes()
    {
        return $this->hasMany(ProjectNote::class);
    }
}
