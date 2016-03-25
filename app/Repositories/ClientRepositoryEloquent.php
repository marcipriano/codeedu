<?php 

namespace App\Repositories;
use App\Entities\Client;
use App\Presenters\ClientPresenter;


use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
	protected $fieldSearchable = [
		'name'
	];

	public function model()
	{
		return Client::class;
	}

	public function presenter()
    {
        return ClientPresenter::class;
    }

	public function boot()
    {
        return $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }
}

?>