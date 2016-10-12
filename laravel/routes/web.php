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
    Route::get('sub-admin', 'AdminController@subAdmin')->name('sub-admin');
    Route::get('add-subadmin', 'AdminController@AddSubAdmin');
    Route::post('add-subadmin', 'AdminController@SaveSubAdmin');
    Route::get('delete-subadmin/{id}', 'AdminController@DeleteSubAdmin')->name('delete-subadmin');
    Route::get('edit-subadmin/{id}', 'AdminController@EditSubAdmin')->name('edit-subadmin');
    Route::post('update-subadmin/{id}', 'AdminController@UpdateSubAdmin')->name('update-subadmin');
    
    /** Master-distributer Route **/
    Route::get('master-distributers', 'DistributerController@masterDistributers')->name('master-distributer');
    Route::get('add-master-distributer', 'DistributerController@AddMasterDistributer');
    Route::post('add-master-distributer', 'DistributerController@SaveMasterDistributer');
    Route::get('delete-master-distributer/{id}', 'DistributerController@DeleteMasterDistributer')->name('delete-master-distributer');
    Route::get('edit-master-distributer/{id}', 'DistributerController@EditMasterDistributer')->name('edit-master-distributer');
    Route::post('update-master-distributer/{id}', 'DistributerController@UpdateMasterDistributer')->name('update-master-distributer');
    
    /** Super-distributer Route **/
    Route::get('super-distributers', 'DistributerController@superDistributers')->name('super-distributer');
    Route::get('add-super-distributer', 'DistributerController@AddSuperDistributer');
    Route::post('add-super-distributer', 'DistributerController@SaveSuperDistributer');
    Route::get('delete-super-distributer/{id}', 'DistributerController@DeleteSuperDistributer')->name('delete-super-distributer');
    Route::get('edit-super-distributer/{id}', 'DistributerController@EditSuperDistributer')->name('edit-super-distributer');
    Route::post('update-super-distributer/{id}', 'DistributerController@UpdateSuperDistributer')->name('update-super-distributer');
    
    /** Distributer Route **/
    Route::get('distributers', 'DistributerController@index')->name('distributer');
    Route::get('add-distributer', 'DistributerController@AddDistributer');
    Route::post('add-distributer', 'DistributerController@SaveDistributer');
    Route::get('delete-distributer/{id}', 'DistributerController@DeleteDistributer')->name('delete-distributer');
    Route::get('edit-distributer/{id}', 'DistributerController@EditDistributer')->name('edit-distributer');
    Route::post('update-distributer/{id}', 'DistributerController@UpdateDistributer')->name('update-distributer');
    
    /** Retailer Route **/
    Route::get('retailer', 'RetailerController@index')->name('retailer');
    Route::get('add-retailer', 'RetailerController@AddRetailer');
    Route::post('add-retailer', 'RetailerController@SaveRetailer');
    Route::get('delete-retailer/{id}', 'RetailerController@DeleteRetailer')->name('delete-retailer');
    Route::get('edit-retailer/{id}', 'RetailerController@EditRetailer')->name('edit-retailer');
    Route::post('update-retailer/{id}', 'RetailerController@UpdateRetailer')->name('update-retailer');
      
    /** Customer Route **/
    Route::get('customers', 'CustomerController@index')->name('customers');
    Route::get('add-customer', 'CustomerController@addCustomer')->name('add-customer');
    Route::post('add-customer', 'CustomerController@saveCustomer')->name('save-customer');
    Route::get('edit-customer/{id}', 'CustomerController@editCustomer')->name('edit-customer');
    Route::put('update-customer/{id}', 'CustomerController@updateCustomer')->name('update-customer');
    Route::get('delete-customer/{id}', 'CustomerController@deleteCustomer')->name('delete-customer');
    Route::get('recharge', 'CustomerController@Recharge')->name('recharge');
    Route::get('recharge-customer/{id}', 'CustomerController@CustomerRecharge')->name('recharge-customer');
 });

//Auth::routes();

Route::get('/home', 'HomeController@index');
