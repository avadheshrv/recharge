<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/', function() {
//     return View::make('login');
// });

Auth::routes();

Route::get('/', function(){
	return redirect('/admin/dashboard');
});
Route::get('/home', 'HomeController@index');

Route::get('/admin/dashboard', 'AdminController@index');

Route::get('/admin/users', 'AdminController@users');

Route::get('/admin/sub-admin', 'AdminController@subAdmin');

Route::get('/admin/master-distributers', 'DistributerController@masterDistributers');

Route::get('/admin/super-distributers', 'DistributerController@superDistributers');

Route::get('/admin/distributers', 'DistributerController@index');

Route::get('/admin/retailer', 'RetailerController@index');

Route::get('/admin/customers', 'CustomerController@index');

Route::get('/admin/add-subadmin', 'AdminController@AddSubAdmin');

Route::post('/admin/add-subadmin', 'AdminController@SaveSubAdmin');


//Auth::routes();

Route::get('/home', 'HomeController@index');
