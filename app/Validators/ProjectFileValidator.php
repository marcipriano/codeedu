<?php 

namespace App\Validators;	

use \Prettus\Validator\LaravelValidator;

 /**
 * 
 */
 class ProjectFileValidator extends LaravelValidator
 {
 	protected $rules = [
 		'project_id' => 'required | integer',
 		'name' => 'required | min: 10 | max:50',
 		//'file' => 'required | mimes: jpeg, jpg, png, gif, pdf, zip',
 		'description' => 'required'
 	];

 }
