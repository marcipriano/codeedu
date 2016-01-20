<?php 

namespace App\Transformers;

use App\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{

	public function transform(User $member)
	{
		return [
			'member_id' => $member->id,
			'name' => $member->name,
			'email' => $member->email
		];
	}
}