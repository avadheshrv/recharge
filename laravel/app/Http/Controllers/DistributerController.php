<?php

namespace App\Http\Controllers;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;

class DistributerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    use RegistersUsers;
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    /**** List all Distributers *****/ 
    public function index()
    {
        $users = User::where('role','distributer')
               ->get();
        $user_role = Auth::user()->role;
        if( $user_role=='admin' || $user_role=='sub-admin' || $user_role=='distributer' || $user_role=='master-distributer' || $user_role=='super-distributer' ){
            return view('distributer.distributers', ['users' => $users] );
        }
        else{
            return redirect()->back();
        }
    }

    /**** List all Master Distributers *****/ 
    public function masterDistributers()
    {
        $users = User::where('role','master-distributer')
               ->get();
         $user_role = Auth::user()->role;
        if( $user_role=='admin' || $user_role=='sub-admin' || $user_role=='master-distributer' ){
            return view('distributer.master-distributers', ['users' => $users] );
        }
        else{
            return redirect()->back();
        }
    }
    /**** List all Super Distributers *****/ 
    public function superDistributers()
    {
        $users = User::where('role','super-distributer')
               ->get();
         $user_role = Auth::user()->role;
        if( $user_role=='admin' || $user_role=='sub-admin' || $user_role=='master-distributer' || $user_role=='super-distributer' ){
            return view('distributer.super-distributers', ['users' => $users] );
        }
        else{
            return redirect()->back();
        }
    }

    protected function DistributerValidater(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password' => 'required|min:6|confirmed',
        ];
        return Validator::make($request->all(), $rules);
    }
    /**** Add Master Distributer Action *****/
    public function AddMasterDistributer()
    {
        $user_role = Auth::user()->role;
        if($user_role == "admin" || $user_role == "sub-admin"){
            return view('distributer.add-master-distributer', ['message' =>'']);
        }
        else{
            return redirect()->back();
        } 
    }
    /**** Save Master Distributer Action *****/
    protected function SaveMasterDistributer(Request $request)
    {

        $validator = $this->DistributerValidater($request);

        if( $validator->passes() ){

            User::create([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'password'      => bcrypt($request['password']),
                'role'          => 'master-distributer'
            ]);
            // $users = User::where('role','admin')->get();
            $message ="Congratulations! Master Distributer has been succesfully added";
            return view('distributer.add-master-distributer', ['message' => $message] );
        }
        else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    /**** Add Super Distributer Action *****/
    public function AddSuperDistributer()
    {
        $user_role = Auth::user()->role;
        if($user_role == "admin" || $user_role == "sub-admin"  || $user_role == "master-distributer"){
            return view('distributer.add-super-distributer', ['message' =>'']);
        }
        else{
            return redirect()->back();
        } 
    }
    /**** Save Super Distributer Action *****/
    protected function SaveSuperDistributer(Request $request)
    {

        $validator = $this->DistributerValidater($request);

        if( $validator->passes() ){

            User::create([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'password'      => bcrypt($request['password']),
                'role'          => 'super-distributer'
            ]);
            // $users = User::where('role','admin')->get();
            $message ="Congratulations! Super Distributer has been succesfully added";
            return view('distributer.add-super-distributer', ['message' => $message] );
        }
        else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    /**** Add Distributer Action *****/
    public function AddDistributer()
    {

        $user_role = Auth::user()->role;
        if($user_role == "admin" || $user_role == "sub-admin"  || $user_role == "master-distributer" || $user_role == "super-distributer"){
            return view('distributer.add-distributer', ['message' =>'']);
        }
        else{
            return redirect()->back();
        } 
    }
    /**** Save Distributer Action *****/
    protected function SaveDistributer(Request $request)
    {

        $validator = $this->DistributerValidater($request);

        if( $validator->passes() ){

            User::create([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'password'      => bcrypt($request['password']),
                'role'          => 'distributer'
            ]);
            // $users = User::where('role','admin')->get();
            $message ="Congratulations! Distributer has been succesfully added";
            return view('distributer.add-distributer', ['message' => $message] );
        }
        else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

}
