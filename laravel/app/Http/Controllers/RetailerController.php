<?php

namespace App\Http\Controllers;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;

class RetailerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    use RegistersUsers;
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $users = User::where('role','retailer')
               ->get();
        $user_role = Auth::user()->role;
        if($user_role == "admin" || $user_role == "sub-admin"  || $user_role == "master-distributer" || $user_role == "super-distributer" || $user_role == "distributer" || $user_role == "retailer"){
            return view('retailer.retailers', ['users' => $users;
        }
        else{
             return redirect()->back();
        }
    }

     protected function RetailerValidater(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password' => 'required|min:6|confirmed',
        ];
        return Validator::make($request->all(), $rules);
    }

    /**** Add REtailer Action *****/
    public function AddRetailer()
    {
        $user_role = Auth::user()->role;
        if($user_role == "admin" || $user_role == "sub-admin"  || $user_role == "master-distributer" || $user_role == "super-distributer" || $user_role == "distributer"){
            return view('retailer.add-retailer', ['message' =>'']);
        }
        else{
            return redirect()->back();
        } 
    }
    /**** Save REtailer Action *****/
    protected function SaveRetailer(Request $request)
    {

        $validator = $this->RetailerValidater($request);

        if( $validator->passes() ){

            User::create([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'password'      => bcrypt($request['password']),
                'role'          => 'retailer'
            ]);
            // $users = User::where('role','admin')->get();
            $message ="Congratulations! Retailer has been succesfully added";
            return view('retailer.add-retailer', ['message' => $message] );
        }
        else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }


}
