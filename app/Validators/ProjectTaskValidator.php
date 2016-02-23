<?php 

namespace App\Validators;	

use \Prettus\Validator\LaravelValidator;

 /**
 * 
 */
 class ProjectTaskValidator extends LaravelValidator
 {
 	protected $rules = [
 		'name' => 'required | min: 10 | max:50',
 		'project_id' => 'required | integer',
 		'start_date' => 'required | date',
 		'due_date' => 'required | date',
 		'status' => 'required | integer'
 		
 	];

 }
