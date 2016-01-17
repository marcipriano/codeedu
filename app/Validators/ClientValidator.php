<?php 

namespace App\Validators;	

use \Prettus\Validator\LaravelValidator;

 /**
 * 
 */
 class ClientValidator extends LaravelValidator
 {
 	protected $rules = [
 		'name' => 'required | max:255',
 		'responsible' => 'required | max:255',
 		'email' => 'required | email',
 		'phone' => 'required',
 		'address' => 'required'
 	];
/*
 	protected $messages = [
    'email.required' => 'O Campo email é obrigatorio!'
	];
 */
 }
