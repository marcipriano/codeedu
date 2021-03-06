<?php 

namespace App\Transformers;

use App\Entities\Client;
use League\Fractal\TransformerAbstract;

class ProjectClientTransformer extends TransformerAbstract
{

	public function transform(Client $client)
	{
		return [
			'id' => $client->id,
			'name' => $client->name,
			'responsible' => $client->responsible,
			'email' => $client->email,
			'phone' => $client->phone,
			'address' => $client->address,
			'obs' => $client->obs
		];
	}
}