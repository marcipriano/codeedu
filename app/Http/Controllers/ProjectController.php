<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\ProjectRepository as ProjectRepository;
use App\Services\ProjectService as ProjectService;
use App\Entities\Project;

class ProjectController extends Controller
{
    private $repository;
    private $service;

    /**
     * Specify connection
     *
     * @return string
     */
     //protected $connection = 'mysql2';


    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->setConnection('mysql2');

        return $project = $this->repository->with(['owner', 'client'])->All();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->service->checkProjectPermission($id) == false) {
            return ['error' => 'Access Forbindden'];
        }

        try {
        $project = $this->repository->with(['owner', 'client', 'members', 'tasks', 'notes', 'files'])->find($id);

        } catch (ModelNotFoundException $e) {
            // something went wrong
            return ['error' => 'Projeto nao localizado'];
        }

        return $project;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        if ($this->service->checkProjectPermission($id) === false) {
            return ['error' => 'Access Forbindden'];
        }

        return $project = $this->service->update($request->all(), $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->service->checkProjectPermission($id) === false) {
            return ['error' => 'Access Forbindden'];
        }

        try {
            $project = $this->repository->delete($id);

        } catch (ModelNotFoundException $e) {
            // something went wrong
            return ['error' => 'Projeto nao localizado'];
        }

        return [$project];
    }

}
