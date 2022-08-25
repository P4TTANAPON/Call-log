<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {

	Route::auth();
	
	Route::get('/', function () {
		return redirect('/job');
	});
	
	Route::get('/browserDetect', 'HomeController@browserDetect');
	Route::get('/userAgent', 'HomeController@userAgent');
	Route::get('/ip', 'HomeController@ip');
	Route::get('/branch', 'HomeController@branch');
	Route::get('/version', 'HomeController@version');
	
	Route::get('/root', 'RootController@index');
	
    Route::get('/dashboard', 'DashboardController@index');
	Route::get('/dashboard/get-week-of-year', 'DashboardController@getWeekOfYear');
	Route::get('/dashboard/get-current-week', 'DashboardController@getCurrentWeek');

	Route::get('/closed', 'ClosedController@index');
	
	Route::get('/job/export', 'JobController@exportExcel');
	Route::get('/job/export-scs', 'JobController@exportExcelSCS');
	Route::get('/job/chart', 'JobController@chart');
	
	Route::get('/job', 'JobController@index');
	Route::get('/job/create', 'JobController@create');
	Route::post('/job', 'JobController@store');
	Route::get('/job/{job}', 'JobController@show');
	Route::get('/job/{job}/edit', 'JobController@edit');
	Route::patch('/job/{job}', 'JobController@update');
	Route::patch('/job/{job}/accept', 'JobController@accept');
	Route::patch('/job/{job}/confirm-close', 'JobController@confirmClose');
	Route::get('/job/{job}/reject', 'JobController@rejectConfirm');
	Route::patch('/job/{job}/reject', 'JobController@reject');
	Route::get('/job/{job}/delete', 'JobController@delete');
	Route::patch('/job/{job}/review', 'JobController@saReview');
	Route::delete('/job/{job}', 'JobController@destroy');

	Route::get('/sat-survey', 'SatSurveyController@index');
	Route::get('/sat-survey/create', 'SatSurveyController@create');
	Route::get('/sat-survey/thank', 'SatSurveyController@thank');
	Route::post('/sat-survey', 'SatSurveyController@store');
	Route::get('/job/{job}/sat-survey', 'SatSurveyController@jobIndex');
	Route::get('/job/{job}/sat-survey/create', 'SatSurveyController@jobCreate');
	Route::post('/job/{job}/sat-survey', 'SatSurveyController@jobStore');
	Route::get('/q', function() {
		return redirect('/sat-survey/create');
	});
	
	Route::get('/scs', 'ScsJobController@index');
	Route::get('/scs/create/{id}', 'ScsJobController@create');
	Route::post('/scs/create/{id}', 'ScsJobController@store');
	Route::get('/scs/{id}/edit', 'ScsJobController@edit');
	
	Route::get('/hw/search', 'HwController@search');
	Route::get('/hw/all', 'HwController@getAll');
	
	Route::get('/hw/ph1', 'Ph1HardwareItemController@index');
	Route::get('/hw/ph1/import', 'Ph1HardwareItemController@import');
	Route::post('/hw/ph1/import', 'Ph1HardwareItemController@import_commit');
	
	Route::get('/hw/ph2', 'Ph2HardwareItemController@index');
	Route::get('/hw/ph2/import', 'Ph2HardwareItemController@import');
	Route::post('/hw/ph2/import', 'Ph2HardwareItemController@import_commit');


	Route::get('/hw', 'HardwareItemController@index');
	
	Route::get('/hw/import', 'HardwareItemController@import');
	Route::post('/hw/import', 'HardwareItemController@import_commit');
	Route::get('/hw/create', 'HardwareItemController@create');
	Route::post('/hw', 'HardwareItemController@store');
	Route::get('/hw/edit', 'HardwareItemController@edit');
	Route::get('/hw/delete', 'HardwareItemController@delete');
	Route::delete('/hw/{job}', 'HardwareItemController@destroy');
	Route::get('/hw/show', 'HardwareItemController@show');

	Route::get('/system/getdropdown', 'SystemController@getdropdown');
	Route::get('/department/getdropdown', 'DepartmentController@getdropdown');
	Route::get('/department/getHWdropdown', 'DepartmentController@getHWdropdown');
	Route::get('/department/getHWDepartment', 'DepartmentController@getHWDepartment');

	Route::get('/department', 'DepartmentController@index');

	Route::get('/dashboard_sla', 'DashboardSlaController@index');

	Route::get('/user/getdropdown', 'UserController@getdropdown');

	Route::get('/onsite', 'OnSiteController@index');
	Route::get('/onsite/export', 'OnSiteController@export2');

	Route::get('/onsite_al','OnSiteAlController@index');

	Route::get('/onsite_hw','OnSiteHwController@index');
});
