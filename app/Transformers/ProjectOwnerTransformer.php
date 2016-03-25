<?php 

namespace App\Transformers;

use App\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectOwnerTransformer extends TransformerAbstract
{

	public function transform(User $own)
	{
		return [
			'owner_id' => $own->id,
			'name' => $own->name,
			'email' => $own->email
		];
	}
}