<?php 

namespace App\Validators;	

use \Prettus\Validator\LaravelValidator;

 /**
 * 
 */
 class ProjectValidator extends LaravelValidator
 {
 	protected $rules = [
 		'name' => 'required | min: 10 | max:50',
 		'description' => 'required | min: 20 | max:255',
 		'progress' => 'required',
 		'client_id' => 'required | integer',
 		'owner_id' => 'required | integer',
    	'status' => 'required',
    	'due_date' => 'required'
 	];

 }
