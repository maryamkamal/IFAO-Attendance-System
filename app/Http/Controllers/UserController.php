<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Exports\UsersExportInsert;
use App\Imports\UsersImport;
use Redirect,Response;
use DataTables;
use PDF;
use Log;
class UserController extends Controller
{
	/*** return user data in users list page with actions usind datatables libarary*****/
	public function index(Request $request){
  if ($request->ajax()) {
     $users = User::all();
     return Datatables::of($users)
     ->addIndexColumn()
     ->addColumn('check_all', function($user){

   $check_all = ' <input type="checkbox" class="checkbox" name="user_ids[]" value="'.$user->id.'"> ';

   return $check_all;
})
   ->addColumn('action', function($user){
  if(auth()->user()->authority('modify','users')==1){
   $btn = ' <span class="edit-btn">
            <a href="users/edit_user/'.$user->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="users/delete_user/'.$user->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span> ';

   return $btn;
}
})
->rawColumns(['action','check_all'])
->make(true);
}
      return view('users.users');
	}
	
	/*** show create user page ***/
	public function create(){
		//retrive roles to create user page 
		 $roles = Role::all();
		 //retrive employees to create user page 
		 $employees =Employee::all()->sortByDesc("full_name_en");
		 return view('users.create_user',['roles'=>$roles,'employees'=>$employees]);
	}
	/** store posted user data  **/
	public function store(Request $request){
		
		$user= new User;
		$user['name']= $request->name;
		$user['email']= $request->email;
		$user['password']= Hash::make($request->password);
		$user['role_id']= $request->role_id;
		$user['employee_id']= $request->employee_id;
		$user->save();
		//redirect to users list page after saving new user
		return redirect("users/index")->with('success', 'user added successfully');
		
		
	}
	/*** show edit user page ***/
	public function edit($id)
   {
	 //retrive user data by id & roles to edit user page 
     $user = User::findOrFail($id);
     $roles = Role::all();
	 $employees = Employee::orderBy('full_name_en','asc')->get();
	 
     return view('users.edit_user',['user'=>$user,'roles'=>$roles,'employees'=>$employees]);
   }
   
   public function update($id, Request $request)
   {
	   /**intializing user record that wanted to be updated ***/
      $user = User::findOrFail($id);
      $user['name']= $request->name;
	  $user['email']= $request->email;
	  $user['password']=  Hash::make($request->password);
	  $user['role_id']= $request->role_id;
	  $user['employee_id']= $request->employee_id;
	  $user->save();
	  
      return redirect("users/index");
    } 
	 /*******  delete user row  ***********/
	public function deleteUser($id)                      
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('users/index')->with('success', 'user is successfully deleted');
    }
	 /*******  delete all checked users  ***********/
	public function deleteSelected(Request $request)                    
	{
      $user_ids = $request->get('user_ids');
        User::destroy($user_ids);
       return redirect('users/index')->with('success', 'Selected users are successfully deleted');
    }
	 /*******  export users excel sheet ***********/
	public function export()  
   {
	   return Excel::download(new UsersExport , 'users.xlsx');
	   return back()->with('success', 'users are exported successfully');
   }
   /*******  export users excel sheet with heading to insert ***********/
	 public function export_insert() 
   {
	   return Excel::download(new UsersExportInsert , 'users_heading.xlsx');
	   return back();
   }
    /*******  import users excel sheet ***********/
	 public function import(Request $request)   
    {
	
        $this->validate($request, [
      'users_import'  => 'required|mimes:xls,xlsx'
     ]);
	    
     Excel::import(new UsersImport, request()->file('users_import'));
	 
     return back()->with('success', 'Excel Data Imported successfully.');
	
	}
	 /*******  print user data in pdf file  ***********/
    public function print_pdf(){    
      $users = User::paginate(15);

      $pdf = PDF::loadView('users.pdf', compact('users'));
      return $pdf->download('users.pdf');
}

}