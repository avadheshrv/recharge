<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class DistributerController extends Controller
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
        $users = User::where('role','distributer')
               ->get();;
        return view('distributer.distributers', ['users' => $users] );
    }


    public function masterDistributers()
    {
        $users = User::where('role','master-distributer')
               ->get();;
        return view('distributer.master-distributers', ['users' => $users] );
    }

     public function superDistributers()
    {
        $users = User::where('role','super-distributer')
               ->get();;
        return view('distributer.super-distributers', ['users' => $users] );
    }

}
