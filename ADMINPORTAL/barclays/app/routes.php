<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
	Route::get('/', 'AuthController@getLogin');
	Route::get('login', 'AuthController@getLogin');
	Route::post('login', 'AuthController@postLogin');

	Route::get('register', 'AuthController@getRegister');
	Route::post('register', 'AuthController@postRegister');
	Route::get('setupone', 'AuthController@registerGroups');
	Route::get('setupthree', 'AuthController@addUserToGroup');
	Route::get('setuptwo', 'AuthController@addUser');

Route::group(array('before'=>'auth'),function(){
		Route::get('logout', 'AuthController@logout');
		Route::resource('auth', 'AuthController');
		Route::resource('dashboard', 'DashboardController');
		Route::resource('branches', 'BranchesController');
		Route::resource('counties', 'CountiesController');
		Route::resource('devices', 'DevicesController');
		Route::resource('inventories', 'InventoriesController');
		Route::resource('issues', 'IssuesController');
		Route::resource('leads', 'LeadsController');
		Route::resource('merchants', 'MerchantsController');
		Route::resource('products', 'ProductsController');

		

		Route::get('dropdown/getUserGroups', function(){
			$groups = Sentry::findAllGroups();
			$groups_data = json_encode((array) $groups);
			return $groups_data;
		});

	});


//api stuff
Route::group(['prefix' => 'api'], function()
{
	Route::post('login', 'AuthController@apiLogin');
	Route::post('leadssave', 'ClientAPIController@save');
	
	Route::group(array('before'=>'auth.token'),function(){
		Route::post('leads/save', 'ClientAPIController@save');
		Route::get('leadsss', 'TypeProductsController@apiget');
		Route::get('designs', 'ProductsController@apiget');
		Route::get('blogs', 'BlogsController@apiget');	
	});
});

Route::group(['prefix' => 'api/public'], function()
{
	Route::group(array('before'=>'public.token'),function(){
		Route::post('leads/save', 'LeadsController@api_store');
		Route::post('issue/save', 'IssuesController@api_store');
	});
});