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
    return view('app');
});

Route::post('oauth/access_token', 	function(){
	return Response::json(Authorizer::issueAccessToken());
});


//Route::group(['prefix' => 'api/v1', 'middleware' => 'oauth'], function () {
Route::group(['middleware' => 'oauth'], function () {
	
	Route::get('authenticated/user', 		'UserController@authenticated');
	
	//routes clients
	Route::resource('user', 'UserController', ['except' => ['create', 'edit']]);
	Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);
	Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
	
	//routes project
	Route::group(['prefix' => 'project'], function () {
		
		//routes project notes
		Route::get('{id}/note', 				'ProjectNoteController@index');
		Route::post('{id}/note', 				'ProjectNoteController@store');
		Route::put('{id}/note/{noteId}', 		'ProjectNoteController@update');
		Route::get('{id}/note/{noteId}', 		'ProjectNoteController@show');
		Route::delete('{id}/note/{noteId}', 	'ProjectNoteController@destroy');
		
		//routes project task
		Route::get('{id}/task', 				'ProjectTaskController@index');
		Route::post('{id}/task', 				'ProjectTaskController@store');
		Route::put('{id}/task/{taskId}', 		'ProjectTaskController@update');
		Route::get('{id}/task/{taskId}', 		'ProjectTaskController@show');
		Route::delete('task/{taskId}', 				'ProjectTaskController@destroy');
		
		//routes project member
		Route::get('{id}/member', 				'ProjectMemberController@index');
		Route::post('{id}/member', 				'ProjectMemberController@store');
		Route::put('{id}/member/{memberId}', 		'ProjectMemberController@update');
		Route::get('{id}/ismember/{memberId}', 		'ProjectMemberController@isMember');
		Route::get('{id}/member/{memberId}', 		'ProjectMemberController@show');
		Route::delete('member/{memberId}', 				'ProjectMemberController@destroy');
		
		Route::get('{id}/file', 				'ProjectFileController@index');
		Route::get('file/{fileId}', 			'ProjectFileController@show');
		Route::get('file/{fileId}/download', 	'ProjectFileController@showFile');
		Route::post('{id}/file', 				'ProjectFileController@store');
		Route::put('{id}/file', 				'ProjectFileController@update');
		Route::delete('file/{fileId}', 				'ProjectFileController@destroy');
		
	});

});