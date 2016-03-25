<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProjectRepository;
use App\Entities\Project;
use App\Presenters\ProjectPresenter;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findRelations($id)
    {
        return $project = $this->model->with(['owner', 'client', 'notes', 'members'])->find($id);

    }

    public function modelAll()
    {
        /*
        return $project = \DB::connection('mysql2')
                ->table('projects')
                ->with(['owner', 'client'])
                ->get();
        //$this->model->connection('mysql2')->with(['owner', 'client'])->all();
        */
        $someModel = new Project;
        $someModel->setConnection('mysql2');
        //return $p = $someModel->with(['owner', 'client'])->find(1);
        return $p = $someModel->all();

        //$this->model->connection('mysql2')->with(['owner', 'client'])->all();

    }

    public function isOwner($projectId, $userId)
    {
        if (count($this->skipPresenter()->findWhere(['id' => $projectId, 'owner_id' => $userId]))) {
            return true;
        }
        return false;

    }

    public function hasMember($projectId, $memberId)
    {
        $project = $this->skipPresenter()->find($projectId);
        // echo "<br>";
        // print_r($project->members);
        foreach ($project->members as $member) {
            if ($member->id == $memberId) {
                return true;
            }
        }
        return false;

    }

    public function presenter()
    {
        return ProjectPresenter::class;
    }
}
