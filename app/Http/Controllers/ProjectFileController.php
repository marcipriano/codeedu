<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository as ProjectRepository;
use App\Services\ProjectService as ProjectService;

class ProjectFileController extends Controller
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
        return $project = $this->repository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['description'] = $request->description;
        $data['project_id'] = $request->id;
        //dd($data);
        $this->service->createFile($data);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->checkProjectPermission($id) == false){
            return ['error' => 'Access forbidden'];
        }
        
        //return $project = $this->repository->findRelations($id);
        return $project = $this->repository->find($id);
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
        if ($this->checkProjectPermission($id) == false){
            return ['error' => 'Access forbidden'];
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
        if ($this->checkProjectPermission($id) == false){
            return ['error' => 'Access forbidden'];
        }

        return $this->repository->delete($id);
    }

    private function checkProjectOwner($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();
       
        return $this->repository->isOwner($projectId, $userId);
        
    }

    private function checkProjectMember($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();
       
        return $this->repository->hasMember($projectId, $userId);
        
    }

    private function checkProjectPermission($projectId)
    {
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }

        return false;
    }
}
