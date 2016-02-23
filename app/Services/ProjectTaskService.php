<?php 
	
	namespace App\Services;


use App\Repositories\ProjectTaskRepository;
use App\Validators\ProjectTaskValidator;
use \Prettus\Validator\Exceptions\ValidatorException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

	class ProjectTaskService
	{
		/**
		* @var ProjectRepository
		*/
		protected $repository;
		
		/**
		* @var validator
		*/
		protected $validator;

		function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
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
				
			} catch (ModelNotFoundException $e) {
				return [
					'error' => true,
					'message' => 'Task nao localizado'
				];
			}
		}
	}


