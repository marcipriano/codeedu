<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository as ProjectRepository;
use App\Services\ProjectService as ProjectService;
use App\Entities\Project;

class ProjectController extends Controller
{
    private $repository;
    private $service;

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
        return $project = $this->repository->with(['owner', 'client'])->all();
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
    {/*
        $p = $this->checkProjectPermission($id);
        if ($p == false){
            return ['error' => 'Access forbidden'];
        }
        if ($p == 'nlocalizado'){
            return ['error' => 'Nao Localizado'];
        }
        */
        //return $project = $this->repository->findRelations($id);
       
        try {
        $project = $this->repository->with(['owner', 'client', 'notes', 'files'])->find($id);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
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
       try {
            $project = $this->repository->delete($id);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // something went wrong
            return ['error' => 'Projeto nao localizado'];
        }

        return $project;
    }

    private function checkProjectOwner($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();
       
        try {
            $owner = $this->repository->isOwner($projectId, $userId);
        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // something went wrong
            return 'nlocalizado';
        }

        return $owner;
    }

    private function checkProjectMember($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();
       
        
        try {
            $member =  $this->repository->hasMember($projectId, $userId);
        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // something went wrong
            return 'nlocalizado';
        }

        return $member;
    }

    private function checkProjectPermission($projectId)
    {
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }

        return false;
    }
}
