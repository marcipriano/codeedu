<?php 
	
	namespace App\Services;


use App\Repositories\ProjectRepository;
use App\Repositories\ProjectMemberRepository;
use App\Validators\ProjectValidator;
use \Prettus\Validator\Exceptions\ValidatorException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Filesystem\Filesystem;
use \Illuminate\Contracts\Filesystem\Factory as Storage;

	class ProjectService
	{
		/**
		* @var ProjectRepository
		*/
		protected $repository;

		/**
		* @var ProjectTaskRepository
		*/
		protected $repositoryMember;
		
		/**
		* @var validator
		*/
		protected $validator;

		private $filesystem;

		private $storage;

		function __construct(
					ProjectRepository $repository, 
					ProjectMemberRepository $repositoryMember, 
					ProjectValidator $validator,
					Filesystem $filesystem,
					Storage $storage)
		{
			$this->repository = $repository;
			$this->repositoryMember = $repositoryMember;
			$this->validator = $validator;
			$this->filesystem = $filesystem;
			$this->storage = $storage;

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
		            $project = $this->repository->update($data, $id);

		        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		            // something went wrong
		            return ['error' => 'Projeto nao localizado'];
		        }

		        return $project;
				
			} catch (ValidatorException $e) {
				return [
					'error' => true,
					'message' => $e->getMessageBag()
				];
			}
		}

		public function createFile(array $data)
		{
			/*
			* name
			* extension
			* file
			*/
			$project = $this->repository->skipPresenter()->find($data['project_id']);
			$projectFile = $project->files()->create($data);

        $this->storage->put($projectFile->name.'.'.$data['extension'], $this->filesystem->get($data['file']));
		
		}

		public function addMember(array $data)
		{
			return $this->repositoryMember->create($data);
		}

		public function removeMember($memberId)
		{
			try {
				$r = $this->repositoryMember->delete($memberId);
				/*
				*	aqui pra mim so da certo se eu retornar entre [$r]. se eu tentar da
				*	o return direto no this ou mesmo na variavel como esta abaixo da o erro
				*	"The Response content must be a string or object implementing __toString(), "boolean""	
				*	vc vem reclamando nas ultimas vezes sobre o retorno entre [] como posso evitar esse erro?
				*/

				//return [$r];
				
			} catch (ModelNotFoundException $e) {
				return [
					'error' => true,
					'message' => 'membro nao localizado'
				];
			}

			return 'true';

		}

	    public function isMember($projectId, $memberId)
	    {
	        return $this->repository->hasMember($projectId, $memberId);
	    }

	}


