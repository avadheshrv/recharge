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
            return view('retailer.retailers', ['users' => $users]);
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

    /****** Delete Retailer *********/
    public function DeleteRetailer($id, Request $request)
    {
        $user = User::find($id); 
        $users = $user->delete();
        if($users){
            return redirect()->route('retailer')->with('message', 'Congratulations! Retailer has been deleted succesfully')->with('status','1');       
        }
        else{
            return redirect()->route('retailer')->with('message', 'Opps! There is some issue while deleting Retailer'); 
        }
        
    }

     /**********Edit REtailer *******/
    public function EditRetailer($id, Request $request)
    {
        $retailer = User::find($id);
        $flash_data = $request->session()->get('flash_data');
        return view('retailer.edit-retailer', ['retailer' => $retailer, 'flash_data' => $flash_data]);  
    }

    /**********Update REtailer *******/
    public function UpdateRetailer($id, Request $request)
    {
        $retailer = User::find($id);
        if($request->password){
            $retailer->name = $request->name;
            $retailer->email = $request->email;
            $retailer->is_active = $request->is_active;
            $retailer->password = bcrypt($request->password);
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
                        'password' => 'required|min:6|confirmed',
                        'password' => 'required|min:6|confirmed'
            ]);
        } else {
            $retailer->name = $request->name;
            $retailer->email = $request->email;
            $retailer->is_active = $request->is_active;
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
            ]);
        }
        
        if ($validator->fails()) {
            return redirect()->route('edit-retailer', ['id' => $retailer->id])->withErrors($validator)->withInput();
        }
        
        $flash_data = [];
        if($retailer->save()){
            $flash_data['status'] = 1;
            $flash_data['message'] = 'Retailer was updated Successfully';
            
        } else{
            $flash_data['status'] = 0;
            $flash_data['message'] = 'Oops! Error Occur while updating Retailer';
            
        }
        $request->session()->flash('flash_data', $flash_data);
        return redirect()->route('edit-retailer', ['id' => $id]); 
    }

}
