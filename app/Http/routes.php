<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token', 	function(){
	return Response::json(Authorizer::issueAccessToken());
});

//Route::group(['prefix' => 'api/v1', 'middleware' => 'oauth'], function () {
Route::group(['middleware' => 'oauth'], function () {
	//routes clients
	Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);
	Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
	
	//routes project
	Route::group(['prefix' => 'project'], function () {
		
		//routes project notes
		Route::get('{id}/notes', 				'ProjectNoteController@index');
		Route::post('{id}/note', 				'ProjectNoteController@store');
		Route::put('{id}/note/{noteId}', 		'ProjectNoteController@update');
		Route::get('{id}/note/{noteId}', 		'ProjectNoteController@show');
		Route::delete('note/{id}', 				'ProjectNoteController@destroy');
		
		//routes project task
		Route::get('{id}/tasks', 				'ProjectTaskController@index');
		Route::post('{id}/task', 				'ProjectTaskController@store');
		Route::put('{id}/task/{taskId}', 		'ProjectTaskController@update');
		Route::get('{id}/task/{taskId}', 		'ProjectTaskController@show');
		Route::delete('task/{taskId}', 				'ProjectTaskController@destroy');
		
		//routes project member
		Route::get('{id}/members', 				'ProjectMemberController@index');
		Route::post('{id}/member', 				'ProjectMemberController@store');
		Route::put('{id}/member/{memberId}', 		'ProjectMemberController@update');
		Route::get('{id}/ismember/{memberId}', 		'ProjectMemberController@isMember');
		Route::get('{id}/member/{memberId}', 		'ProjectMemberController@show');
		Route::delete('member/{memberId}', 				'ProjectMemberController@destroy');
		
		Route::post('{id}/file', 				'ProjectFileController@store');
		
	});

});