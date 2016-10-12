<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $users = User::where('role', 'general')
                ->get();
        $user = Auth::User();
        //echo "<pre>"; print_r($user->role);exit;
        $flash_data = $request->session()->get('flash_data');
        return view('customer.customers', ['users' => $users, 'user' => $user, 'flash_data' => $flash_data]);
    }

    public function addCustomer(Request $request) {
        $flash_data = $request->session()->get('flash_data');
        return view('customer.add-customer', ['flash_data' => $flash_data]);
    }

    public function saveCustomer(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|min:6|confirmed',
                    'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->route('add-customer')->withErrors($validator)->withInput();
        }

        $newCustomer = new User;
        $newCustomer->name = $request['name'];
        $newCustomer->email = $request['email'];
        $newCustomer->password = bcrypt($request['password']);
        $newCustomer->role = 'general';
        
        $flash_data = [];
        if($newCustomer->save()){
            $flash_data['status'] = 1;
            $flash_data['message'] = 'Customer was added Successfully';
            
        } else{
            $flash_data['status'] = 0;
            $flash_data['message'] = 'Oops! Error Occur while saving customer';
            
        }
        $request->session()->flash('flash_data', $flash_data);
        return redirect()->route('add-customer');
        
    }
    
    public function editCustomer($id, Request $request){
        $customer = User::find($id);
        $flash_data = $request->session()->get('flash_data');
        return view('customer.edit-customer', ['customer' => $customer, 'flash_data' => $flash_data]);
        
    }
    
    public function updateCustomer($id, Request $request){
        $customer = User::find($id);
        if($request->password){
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->is_active = $request->is_active;
            $customer->password = bcrypt($request->password);
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
                        'password' => 'required|min:6|confirmed',
                        'password' => 'required|min:6|confirmed'
            ]);
        } else {
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->is_active = $request->is_active;
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
            ]);
        }
        
        if ($validator->fails()) {
            return redirect()->route('edit-customer', ['id' => $customer->id])->withErrors($validator)->withInput();
        }
        
        $flash_data = [];
        if($customer->save()){
            $flash_data['status'] = 1;
            $flash_data['message'] = 'Customer was updated Successfully';
            
        } else{
            $flash_data['status'] = 0;
            $flash_data['message'] = 'Oops! Error Occur while updating customer';
            
        }
        $request->session()->flash('flash_data', $flash_data);
        return redirect()->route('edit-customer', ['id' => $id]);
    }
    
    public function deleteCustomer($id, Request $request){
        $flash_data = [];
        if(User::destroy($id)){
            $flash_data['status'] = 1;
            $flash_data['message'] = 'Customer was deleted Successfully';
        }else{
            $flash_data['status'] = 0;
            $flash_data['message'] = 'Oops! Error occur while deleting customer';
        }
        $request->session()->flash('flash_data', $flash_data);
        return redirect()->route('customers');
        
    }

    /**** Recharge Funtionality ************/
    public function Recharge(Request $request) {
        $users = User::where('role', 'general')
                ->get();
        $user = Auth::User();
        return view('customer.customer-recharge', ['users' => $users, 'user' => $user]);
    }

    public function CustomerRecharge($id, Request $request) {
        $customer = User::find($id);
        $flash_data = $request->session()->get('flash_data');
        return view('customer.customer-recharge-form', ['customer' => $customer, 'flash_data' => $flash_data]);
    }

}
