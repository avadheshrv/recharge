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
    public function index() {
        $users = User::where('role', 'general')
                ->get();
        $user = Auth::User();
        //echo "<pre>"; print_r($user->role);exit;
        return view('customer.customers', ['users' => $users, 'user' => $user]);
    }

    public function addCustomer() {
        //$users = User::where('role','admin')->get();
        return view('customer.add-customer', ['message' => '']);
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
        
        $bind = [];
        if($newCustomer->save()){
            $bind['status'] = 1;
            $bind['message'] = 'Customer was added Successfully';
            
        } else{
            $bind['status'] = 0;
            $bind['message'] = 'Customer was added Successfully';
            
        }
        $request->session()->flash('bind', $bind);
        
        
        
        
    }

}
