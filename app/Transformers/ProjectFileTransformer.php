<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\ProjectFile;

/**
 * Class ProjectFileTransformer
 * @package namespace App\Transformers;
 */
class ProjectFileTransformer extends TransformerAbstract
{

    /**
     * Transform the \ProjectFile entity
     * @param \ProjectFile $model
     *
     * @return array
     */
    public function transform(ProjectFile $model)
    {
        return [
            'id'         => (int) $model->id,
            'project_id'         => (int) $model->project_id,
            'name' => $model->name,
            'description' => $model->description,
            'extension' => $model->extension
        ];
    }
}
