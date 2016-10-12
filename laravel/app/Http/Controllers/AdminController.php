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

    public function DeleteSubAdmin($id, Request $request)
    {
        $user = User::find($id); 
        $users = $user->delete();
        if($users){
            return redirect()->route('sub-admin')->with('message', 'Congratulations! Sub admin has been deleted succesfully')->with('status','1');       
        }
        else{
            return redirect()->route('sub-admin')->with('message', 'Opps! There is some issue while deleting Sub admin'); 
        }
        
    }

    /**********Edit Sub admin *******/
    public function EditSubAdmin($id, Request $request)
    {
        $subAdmin = User::find($id);
        $flash_data = $request->session()->get('flash_data');
        return view('auth.edit-sub-admin', ['subAdmin' => $subAdmin, 'flash_data' => $flash_data]);  
    }

    /**********Update Sub admin *******/
    public function UpdateSubAdmin($id, Request $request)
    {
        $subAdmin = User::find($id);
       // $subAdmin->name = $request->is_active; die();
        if($request->password){
            $subAdmin->name = $request->name;
            $subAdmin->email = $request->email;
            $subAdmin->password = bcrypt($request->password);
            $subAdmin->is_active = $request->is_active;
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
                        'password' => 'required|min:6|confirmed',
                        'password' => 'required|min:6|confirmed'
            ]);
        } else {
            $subAdmin->name = $request->name;
            $subAdmin->email = $request->email;
            $subAdmin->is_active = $request->is_active;
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
            ]);
        }
        
        if ($validator->fails()) {
            return redirect()->route('edit-subadmin', ['id' => $subAdmin->id])->withErrors($validator)->withInput();
        }
        
        $flash_data = [];
        if($subAdmin->save()){
            $flash_data['status'] = 1;
            $flash_data['message'] = 'Sub admin was updated Successfully';
            
        } else{
            $flash_data['status'] = 0;
            $flash_data['message'] = 'Oops! Error Occur while updating sub-admin';
            
        }
        $request->session()->flash('flash_data', $flash_data);
        return redirect()->route('edit-subadmin', ['id' => $id]); 
    }

}