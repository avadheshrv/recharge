<?php

namespace App\Http\Controllers;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;

class AdminController extends Controller
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

  
    protected function SubAdminValidate(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password' => 'required|min:6|confirmed',
        ];
        return Validator::make($request->all(), $rules);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin-home');
    }

    public function users()
    {
        $users = User::all();
        $user_role = Auth::user()->role;
        if($user_role=='admin'){
            return view('admin-users', ['users' => $users] );
        }
        else{
             return redirect()->back();
        }
    }

    public function subAdmin()
    {
        $users = User::where('role','sub-admin')->get();
        $user_role = Auth::user()->role;
        if($user_role=='admin' || $user_role=='sub-admin'){
            return view('sub-admin', ['users' => $users]);
        }
        else{
            return redirect()->back();
        } 
    }

    public function AddSubAdmin()
    {
        $user_role = Auth::user()->role;
        if($user_role=='admin'){
            return view('auth.add-sub-admin', ['message' =>'']);    
        }
        else{
            return redirect()->back();
        }     
    }

    protected function SaveSubAdmin(Request $request)
    {

        $validator = $this->SubAdminValidate($request);

        if( $validator->passes() ){

            User::create([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'password'      => bcrypt($request['password']),
                'role'          => 'sub-admin'
            ]);
            // $users = User::where('role','admin')->get();
            $message ="Congratulations! Sub admin has been succesfully added";
            return view('auth.add-sub-admin', ['message' => $message] );
        }
        else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function DeleteSubAdmin()
    {
        $user = User::find($id); 
        $user->delete();
        $users = User::where('role','sub-admin')->get();
        return view('sub-admin', ['users' => $users]);             
    }
}