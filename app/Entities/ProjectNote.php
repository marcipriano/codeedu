<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectNote extends Model implements Transformable
{
    use SoftDeletes;
    use TransformableTrait;

    protected $fillable = [
    	'project_id',
    	'title',
    	'note',
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

}
