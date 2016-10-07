<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role','general')
               ->get();
        $user = Auth::User();
        //echo "<pre>"; print_r($user->role);exit;
        return view('customer.customers', ['users' => $users,'user' => $user] );
    }

}
