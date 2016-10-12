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

    /****** Delete Master Distributer *********/
    public function DeleteMasterDistributer($id, Request $request)
    {
        $user = User::find($id); 
        $users = $user->delete();
        if($users){
            return redirect()->route('master-distributer')->with('message', 'Congratulations! Master Distributer has been deleted succesfully')->with('status','1');       
        }
        else{
            return redirect()->route('master-distributer')->with('message', 'Opps! There is some issue while deleting Master Distributer'); 
        }
        
    }

    /****** Delete Super Distributer *********/
    public function DeleteSuperDistributer($id, Request $request)
    {
        $user = User::find($id); 
        $users = $user->delete();
        if($users){
            return redirect()->route('super-distributer')->with('message', 'Congratulations! Super Distributer has been deleted succesfully')->with('status','1');       
        }
        else{
            return redirect()->route('super-distributer')->with('message', 'Opps! There is some issue while deleting Super Distributer'); 
        }
        
    }
    /****** Delete Distributer *********/
    public function DeleteDistributer($id, Request $request)
    {
        $user = User::find($id); 
        $users = $user->delete();
        if($users){
            return redirect()->route('distributer')->with('message', 'Congratulations! Distributer has been deleted succesfully')->with('status','1');       
        }
        else{
            return redirect()->route('distributer')->with('message', 'Opps! There is some issue while deleting Distributer'); 
        }
        
    }

        /**********Edit Master distributer *******/
    public function EditMasterDistributer($id, Request $request)
    {
        $masterDistributer = User::find($id);
        $flash_data = $request->session()->get('flash_data');
        return view('distributer.edit-master-distributer', ['masterDistributer' => $masterDistributer, 'flash_data' => $flash_data]);  
    }

    /**********Update Master distributer *******/
    public function UpdateMasterDistributer($id, Request $request)
    {
        $masterDistributer = User::find($id);
        if($request->password){
            $masterDistributer->name = $request->name;
            $masterDistributer->email = $request->email;
            $masterDistributer->is_active = $request->is_active;
            $masterDistributer->password = bcrypt($request->password);
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
                        'password' => 'required|min:6|confirmed',
                        'password' => 'required|min:6|confirmed'
            ]);
        } else {
            $masterDistributer->name = $request->name;
            $masterDistributer->email = $request->email;
            $masterDistributer->is_active = $request->is_active;
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
            ]);
        }
        
        if ($validator->fails()) {
            return redirect()->route('edit-master-distributer', ['id' => $masterDistributer->id])->withErrors($validator)->withInput();
        }
        
        $flash_data = [];
        if($masterDistributer->save()){
            $flash_data['status'] = 1;
            $flash_data['message'] = 'Master Distributer was updated Successfully';
            
        } else{
            $flash_data['status'] = 0;
            $flash_data['message'] = 'Oops! Error Occur while updating Master Distributer';
            
        }
        $request->session()->flash('flash_data', $flash_data);
        return redirect()->route('edit-master-distributer', ['id' => $id]); 
    }

    /**********Edit Super distributer *******/
    public function EditSuperDistributer($id, Request $request)
    {
        $superDistributer = User::find($id);
        $flash_data = $request->session()->get('flash_data');
        return view('distributer.edit-super-distributer', ['superDistributer' => $superDistributer, 'flash_data' => $flash_data]);  
    }

    /**********Update Super distributer *******/
    public function UpdateSuperDistributer($id, Request $request)
    {
        $superDistributer = User::find($id);
        if($request->password){
            $superDistributer->name = $request->name;
            $superDistributer->email = $request->email;
            $superDistributer->is_active = $request->is_active;
            $superDistributer->password = bcrypt($request->password);
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
                        'password' => 'required|min:6|confirmed',
                        'password' => 'required|min:6|confirmed'
            ]);
        } else {
            $superDistributer->name = $request->name;
            $superDistributer->email = $request->email;
            $superDistributer->is_active = $request->is_active;
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
            ]);
        }
        
        if ($validator->fails()) {
            return redirect()->route('edit-super-distributer', ['id' => $superDistributer->id])->withErrors($validator)->withInput();
        }
        
        $flash_data = [];
        if($superDistributer->save()){
            $flash_data['status'] = 1;
            $flash_data['message'] = 'Super Distributer was updated Successfully';
            
        } else{
            $flash_data['status'] = 0;
            $flash_data['message'] = 'Oops! Error Occur while updating Super Distributer';
            
        }
        $request->session()->flash('flash_data', $flash_data);
        return redirect()->route('edit-super-distributer', ['id' => $id]); 
    }

    /**********Edit distributer *******/
    public function EditDistributer($id, Request $request)
    {
        $Distributer = User::find($id);
        $flash_data = $request->session()->get('flash_data');
        return view('distributer.edit-distributer', ['Distributer' => $Distributer, 'flash_data' => $flash_data]);  
    }

    /**********Update distributer *******/
    public function UpdateDistributer($id, Request $request)
    {
        $Distributer = User::find($id);
        if($request->password){
            $Distributer->name = $request->name;
            $Distributer->email = $request->email;
            $Distributer->is_active = $request->is_active;
            $Distributer->password = bcrypt($request->password);
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
                        'password' => 'required|min:6|confirmed',
                        'password' => 'required|min:6|confirmed'
            ]);
        } else {
            $Distributer->name = $request->name;
            $Distributer->email = $request->email;
            $Distributer->is_active = $request->is_active;
            $validator = Validator::make($request->all(), [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users,email,'.$id,
            ]);
        }
        
        if ($validator->fails()) {
            return redirect()->route('edit-distributer', ['id' => $Distributer->id])->withErrors($validator)->withInput();
        }
        
        $flash_data = [];
        if($Distributer->save()){
            $flash_data['status'] = 1;
            $flash_data['message'] = 'Distributer was updated Successfully';
            
        } else{
            $flash_data['status'] = 0;
            $flash_data['message'] = 'Oops! Error Occur while updating Distributer';
            
        }
        $request->session()->flash('flash_data', $flash_data);
        return redirect()->route('edit-distributer', ['id' => $id]); 
    }
}
