<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository;
use App\Repositories\ClientRepository as ClientRepository;
use App\Services\ClientService as ClientService;

class ClientController extends Controller
{
    
    private $repository;
    private $service;
    private $projectRepository;

    public function __construct(
                ClientRepository $repository, 
                ClientService $service, 
                ProjectRepository $projectRepository)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->projectRepository = $projectRepository;
    }
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c = $this->repository->all();
        return $c;
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
        try {
            $c = $this->repository->find($id);
        
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // something went wrong
            return ['error' => 'Cliente nao localizado'];
        }

        return $c;
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
       return $client = $this->service->update($request->all(), $id);
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
            $c = $this->repository->find($id);
            foreach ($c->project as $pro) {
                //apagar notas
                $this->projectRepository->find($pro->id)->notes->each(function ($note) {
                   $note->delete();
                });
                //apagar files
                $this->projectRepository->find($pro->id)->files->each(function ($file) {
                   $file->delete();
                });
                //apagar projetos
                $this->repository->find($id)->project->each(function ($project) {
                   $project->delete();
                });

            }
            //apagar cliente
            $c->delete();
            
            return 'true';

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // something went wrong
            return ['error' => 'Cliente nao localizado'];
        }
        
    }

}
