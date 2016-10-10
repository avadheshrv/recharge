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
    Route::get('add-master-distributer', 'DistributerController@AddMasterDistributer');
    Route::post('add-master-distributer', 'DistributerController@SaveMasterDistributer');
    
    /** Super-distributer Route **/
    Route::get('super-distributers', 'DistributerController@superDistributers');
    Route::get('add-super-distributer', 'DistributerController@AddSuperDistributer');
    Route::post('add-super-distributer', 'DistributerController@SaveSuperDistributer');
    
    /** Distributer Route **/
    Route::get('distributers', 'DistributerController@index');
    Route::get('add-distributer', 'DistributerController@AddDistributer');
    Route::post('/add-distributer', 'DistributerController@SaveDistributer');
    
    /** Retailer Route **/
    Route::get('retailer', 'RetailerController@index');
    Route::get('add-retailer', 'RetailerController@AddRetailer');
    Route::post('add-retailer', 'RetailerController@SaveRetailer');
      
    /** Customer Route **/
    Route::get('customers', 'CustomerController@index')->name('customers');
    Route::get('add-customer', 'CustomerController@addCustomer')->name('add-customer');
    Route::post('add-customer', 'CustomerController@saveCustomer')->name('save-customer');
    Route::get('edit-customer/{id}', 'CustomerController@editCustomer')->name('edit-customer');
    Route::put('update-customer/{id}', 'CustomerController@updateCustomer')->name('update-customer');
    Route::get('delete-customer/{id}', 'CustomerController@deleteCustomer')->name('delete-customer');
    

    
});



//Auth::routes();

Route::get('/home', 'HomeController@index');
