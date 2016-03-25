<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository as ProjectRepository;
use App\Services\ProjectService as ProjectService;
use App\Repositories\ProjectFileRepository as ProjectFileRepository;
use App\Services\ProjectFileService as ProjectFileService;

class ProjectFileController extends Controller
{
    private $projectRepository;
    private $projectService;
    private $repository;
    private $service;

    public function __construct(
                    ProjectRepository $projectRepository, 
                    ProjectService $projectService,
                    ProjectFileRepository $repository, 
                    ProjectFileService $service)
    {
        $this->projectRepository = $projectRepository;
        $this->projectService = $projectService;
        $this->repository = $repository;
        $this->service = $service;
    }
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return $project = $this->repository->findWhere(['project_id' => $id]);
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

        return $this->service->createFile($data);
        
    }

    public function showFile($id)
    {
/*
        if ($this->service->checkProjectPermission($id) == false) {
            return ['error' => 'Access Forbindden'];
        }
*/
        $filePath = $this->service->getFilePath($id);
        $fileContent = file_get_contents($filePath);
        $file64 = base64_encode($fileContent);
        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => $this->service->getFileName($id)
        ];
        // return response()->download($this->service->getFilePath($id));
    }

    public function show($id)
    {
    /*
        if ($this->service->checkProjectPermission($id) == false) {
            return ['error' => 'Access Forbindden'];
        }
    */
        return $this->repository->find($id);
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
    /*
        if ($this->service->checkProjectPermission($id) == false){
            return ['error' => 'Access forbidden'];
        }
    */
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
        /*
        if ($this->service->checkProjectPermission($id) == false){
            return ['error' => 'Access forbidden'];
        }
        */
        $this->service->delete($id);
    }

}
