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
    protected $redirectTo = '/admin/sub-admin';


    public function __construct()
    {
        $this->middleware('auth');
    }

  
    protected function SubAdminValidate(Request $request)
    {
        $rules = array(
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password' => 'required|min:6|confirmed',
        );
          $this->validate( $request , $rules);
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
        return view('admin-users', ['users' => $users] );
    }

    public function subAdmin()
    {
        $users = User::where('role','sub-admin')->get();
        return view('sub-admin', ['users' => $users]);
    }

    public function AddSubAdmin()
    {

        $users = User::where('role','admin')->get();
        return view('auth.add-sub-admin', ['message' =>'']);
    }

    protected function SaveSubAdmin(Request $request)
    {

        $validator = $this->SubAdminValidate($request);

        if( $validator->passes() ){
            echo "string";
            echo die();
            User::create([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'password'      => bcrypt($request['password']),
                'role'          => 'sub-admin'
            ]);
            // $users = User::where('role','admin')->get();
            $message ="<strong>Congratulations!</strong>Sub admin has been succesfully added";
            return view('auth.add-sub-admin', ['message' => $message] );
        }
        else{
            return redirect()->back()->withErrors();
        }
    }
}