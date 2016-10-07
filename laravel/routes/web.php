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

Route::get('/', function() {
    return redirect('/admin/dashboard');
});
Route::get('/home', 'HomeController@index');


Route::group(['prefix' => 'admin'], function () {


    Route::get('dashboard', 'AdminController@index')->name('dashboard');

    Route::get('users', 'AdminController@users');

    /** Sub-admin Route **/
    Route::get('sub-admin', 'AdminController@subAdmin');
    Route::get('add-subadmin', 'AdminController@AddSubAdmin');
    Route::post('add-subadmin', 'AdminController@SaveSubAdmin');
    
    /** Master-distributer Route **/
    Route::get('master-distributers', 'DistributerController@masterDistributers');
    
    /** Super-distributer Route **/
    Route::get('super-distributers', 'DistributerController@superDistributers');
    
    /** Distributer Route **/
    Route::get('distributers', 'DistributerController@index');
    
    /** Retailer Route **/
    Route::get('retailer', 'RetailerController@index');
      
    /** Customer Route **/
    Route::get('customers', 'CustomerController@index');
    Route::get('add-customer', 'CustomerController@addCustomer')->name('add-customer');
    Route::post('add-customer', 'CustomerController@saveCustomer')->name('save-customer');
    

    
});


Route::get('/admin/add-master-distributer', 'DistributerController@AddMasterDistributer');

Route::post('/admin/add-master-distributer', 'DistributerController@SaveMasterDistributer');

Route::get('/admin/add-super-distributer', 'DistributerController@AddSuperDistributer');

Route::post('/admin/add-super-distributer', 'DistributerController@SaveSuperDistributer');

Route::get('/admin/add-distributer', 'DistributerController@AddDistributer');

Route::post('/admin/add-distributer', 'DistributerController@SaveDistributer');

Route::get('/admin/add-retailer', 'RetailerController@AddRetailer');

Route::post('/admin/add-retailer', 'RetailerController@SaveRetailer');


//Auth::routes();

Route::get('/home', 'HomeController@index');
