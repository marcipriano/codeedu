<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectMemberRepository as ProjectMemberRepository;
use App\Services\ProjectMemberService as ProjectMemberService;
use App\Services\ProjectService as ProjectService;

class ProjectMemberController extends Controller
{
    private $repository;
    private $service;
    private $serviceProject;

    public function __construct(
                ProjectMemberRepository $repository, 
                ProjectMemberService $service,
                ProjectService $serviceProject)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->serviceProject = $serviceProject;
    }
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return $this->repository->with(['project', 'member'])->findWhere(['project_id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->serviceProject->addMember($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $memberId)
    {
        return $project = $this->repository->with(['project', 'member'])->findWhere(['project_id' => $id, 'id' => $memberId]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $memberId)
    {
       return $project = $this->service->update($request->all(), $memberId);
    }

    public function isMember($id, $memberId)
    {
       $is = $this->serviceProject->isMember($id, $memberId);
       return [$is];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $memberId
     * @return \Illuminate\Http\Response
     */
    public function destroy($memberId)
    {
        return $this->serviceProject->removeMember($memberId);
    }

}
