<?php 
	
	namespace App\Services;


use App\Repositories\ProjectRepository as ProjectRepository;
use App\Validators\ProjectValidator;
use \Prettus\Validator\Exceptions\ValidatorException;

	class ProjectService
	{
		/**
		* @var ProjectRepository
		*/
		protected $repository;
		
		/**
		* @var validator
		*/
		protected $validator;

		function __construct(ProjectRepository $repository, ProjectValidator $validator)
		{
			$this->repository = $repository;
			$this->validator = $validator;
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
				return $this->repository->update($data, $id);
				
			} catch (ValidatorException $e) {
				return [
					'error' => true,
					'message' => $e->getMessageBag()
				];
			}
		}
	}


