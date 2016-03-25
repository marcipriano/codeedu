<?php 
	
	namespace App\Services;


use App\Repositories\ProjectRepository;
use App\Repositories\ProjectFileRepository;
use App\Services\ProjectService;
use App\Validators\ProjectFileValidator;
use \Prettus\Validator\Exceptions\ValidatorException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Filesystem\Filesystem;
use \Illuminate\Contracts\Filesystem\Factory as FacStorage;

	class ProjectFileService
	{
		/**
		* @var ProjectRepository
		*/
		protected $repository;

		protected $projectRepository;

		protected $projectService;

		protected $validator;
		
		private $filesystem;

		private $storage;

		function __construct(
					ProjectFileRepository $repository, 
					ProjectRepository $projectRepository, 
					ProjectService $projectService, 
					ProjectFileValidator $validator, 
					Filesystem $filesystem,
					FacStorage $storage)
		{
			$this->repository 			= $repository;
			$this->projectRepository 	= $projectRepository;
			$this->projectService 		= $projectService;
			$this->validator 			= $validator;
			$this->filesystem 			= $filesystem;
			$this->storage 				= $storage;

		}

		public function createFile(array $data)
		{
			/*
			* name
			* extension
			* file
			*/
			try {

				$this->validator->with($data)->passesOrFail();
							
				$project = $this->projectRepository->skipPresenter()->find($data['project_id']);
				
				if (!$this->storage->exists($this->storage->getDriver()->getAdapter()->getPathPrefix() . '/' . $data['project_id'])) {
					\Storage::makeDirectory($data['project_id']);
				}

				$projectFile = $project->files()->create($data);

	        	$this->storage->put($data['project_id'] . '/'. $projectFile->getFileName(), $this->filesystem->get($data['file']));
				
				return $projectFile;

			} catch (ValidatorException $e) {
				return [
					'error' => true,
					'message'	=> 	$e->getMessageBag()
				];
			}

		
		}

		public function update(array $data, $id)
		{
			/*
			* name
			* extension
			* file
			*/
			try {

				$this->validator->with($data)->passesOrFail();
			
				return $this->repository->update($data, $id);

			} catch (ValidatorException $e) {
				return [
					'error' => true,
					'message'	=> 	$e->getMessageBag()
				];
			}

		}

		public function delete($id)
		{
			$projectFile = $this->repository->skipPresenter()->find($id);
			if ($this->storage->exists($projectFile->project_id . '/'. $projectFile->getFileName())) 
			{
				$this->storage->delete($projectFile->project_id . '/'. $projectFile->getFileName());
				$projectFile->delete();
			}
		}

		public function getFilePath($id)
		{
			$projectFile = $this->repository->skipPresenter()->find($id);

			return $this->getBaseUrl($projectFile);
		}

		public function getFileName($id)
		{
			$projectFile = $this->repository->skipPresenter()->find($id);

			return $projectFile->getFileName();
		}

		private function getBaseUrl($projectFile)
		{
			switch ($this->storage->getDefaultDriver()) {
				case 'local':
					return $this->storage->getDriver()->getAdapter()->getPathPrefix()
					. '/' . $projectFile->project_id . '/' . $projectFile->getFileName();
					break;
			}
		}


    public function checkProjectPermission($projectFileId)
    {

        $userId 	= \Authorizer::getResourceOwnerId();
        $projectId 	= $this->repository->skipPresenter()->find($projectFileId)->project_id;
        if ($this->projectRepository->isOwner($projectId, $userId) or 
        	$this->projectRepository->hasMember($projectId, $userId)){
            return true;
        }
        return false;
    }

	}


