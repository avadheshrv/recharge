<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $users = User::where('role','retailer')
               ->get();
        return view('retailer.retailers', ['users' => $users] );
    }

}