<?php 

namespace App\Repositories;
use App\Entities\User;


use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
	public function model()
	{
		return User::class;
	}

}

?>