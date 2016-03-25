<?php 

namespace App\Transformers;

use App\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['client', 'owner', 'members', 'files', 'notes', 'tasks'];
	
	public function transform(Project $project)
	{
		return [
			'id' => $project->id,
			'client_id' => $project->client_id,
			'owner_id' => $project->owner_id,
			'name' => $project->name,
			'description' => $project->description,
			'progress' => (int)$project->progress,
			'status' => $project->status,
			'due_date' => $project->due_date
		];
	}

	public function includeClient(Project $project)
	{
		return $this->item($project->client, new ProjectClientTransformer());
	}

	public function includeOwner(Project $project)
	{
		return $this->item($project->owner, new ProjectOwnerTransformer());
	}

	public function includeMembers(Project $project)
	{
		return $this->collection($project->members, new ProjectMemberTransformer());
	}

	public function includeFiles(Project $project)
	{
		return $this->collection($project->files, new ProjectFileTransformer());
	}

	public function includeNotes(Project $project)
	{
		return $this->collection($project->notes, new ProjectNoteTransformer());
	}

	public function includeTasks(Project $project)
	{
		return $this->collection($project->tasks, new ProjectTaskTransformer());
	}

}