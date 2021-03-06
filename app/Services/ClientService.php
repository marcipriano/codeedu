<?php 
	
	namespace App\Services;


use App\Repositories\ClientRepository as ClientRepository;
use App\Validators\ClientValidator;
use \Prettus\Validator\Exceptions\ValidatorException;

	class ClientService
	{
		/**
		* @var ClientRepository
		*/
		protected $repository;
		
		/**
		* @var validator
		*/
		protected $validator;

		function __construct(ClientRepository $repository, ClientValidator $validator)
		{
			$this->repository = $repository;
			$this->validator = $validator;
		}
	
		public function all()
		{
			return $this->repository->all();
		}

		public function create(array $data)
		{
			try {
				$this->validator->with($data)->passesOrFail();
				return $this->repository->create($data);
				
			} catch (ValidatorException $e) {
				return [
					'error' => true,
					'message' => $e->getMessageBag()
				];
			}
		}

		public function update(array $data, $id)
		{
			try {
				$this->validator->with($data)->passesOrFail();
				
		        try {
		            $client = $this->repository->update($data, $id);

		        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		            // something went wrong
		            return ['error' => 'Cliente nao localizado'];
		        }

		        return $client;

			} catch (ValidatorException $e) {
				return [
					'error' => true,
					'message' => $e->getMessageBag()
				];
			}
		}
	}


