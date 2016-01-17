<?php 

namespace App\Validators;	

use \Prettus\Validator\LaravelValidator;

 /**
 * 
 */
 class ProjectValidator extends LaravelValidator
 {
 	protected $rules = [
 		'name' => 'required | max:50',
 		'description' => 'required | max:255',
 		'progress' => 'required',
 		'client_id' => 'required',
 		'owner_id' => 'required',
    	'status' => 'required',
    	'due_date' => 'required'
 	];

 }
