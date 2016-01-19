<?php 

namespace App\Validators;	

use \Prettus\Validator\LaravelValidator;

 /**
 * 
 */
 class ProjectNoteValidator extends LaravelValidator
 {
 	protected $rules = [
 		'project_id' => 'required | integer',
 		'title' => 'required | min: 10 | max:50',
 		'note' => 'required'
 	];

 }
