<?php

namespace App\Http\Controllers;
use App\Role;
use App\User;
use App\Page;
use App\RoleAuthority;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Log;
class RoleController extends Controller
{
	public function index(Request $request){
	
	    $roles = Role::orderBy('id','asc')->get();
		 return view('roles.index',['roles'=>$roles]);
	}
  /*** show create role page with roles list table ***/
	public function create(Request $request){
	
	    $pages = Page::orderBy('id','asc')->get();
		 return view('roles.create',['pages'=>$pages]);
	}
	
	/****store role data***/
	public function store(Request $request){
		$pages = Page::orderBy('id','asc')->get();
		//create new role
		$role = new Role;
		$role['name']= $request->name;
		$role->save();
		Log::info($request->name." Role Added By ".auth()->user()->employee->full_name_en);
		//save newly created role authorities
		
		$role_id = Role::max('id');
		$counter =0;
		$count = count($pages);
		while($counter < $count){
			$RoleAuthority= new RoleAuthority;
			$RoleAuthority->role_id =$role_id;
			$RoleAuthority->page =$pages[$counter]['name'];
			if(isset($request->view[$counter])){
			$RoleAuthority->view =$request->view[$counter];
			}
			else{
				$RoleAuthority->view=0;
			}
			if(isset($request->modify[$counter])){
			$RoleAuthority->modify =$request->modify[$counter];
			}
			else{
				$RoleAuthority->modify=0;
			}
			if(isset($request->export[$counter])){
			$RoleAuthority->export =$request->export[$counter];
			}
			else{
				$RoleAuthority->export=0;
			}
			if(isset($request->view_only_employee_data[$counter])){
			$RoleAuthority->export =$request->view_only_employee_data[$counter];
			}
			else{
				$RoleAuthority->view_only_employee_data=0;
			}
			$RoleAuthority->save();
			$counter++;
	}	
		return redirect("roles/index")->with('success', 'Role is successfully added');
	}
	 /*** show edit role page ***/
	public function edit($id)
   {
	 $role= Role::find($id);
	 $pages = Page::orderBy('id','asc')->get();
     return view('roles.edit',compact('role','pages'));
   }
   /************** update role record in db  *****************/
	 public function update($id, Request $request)
   {
	  $pages = Page::orderBy('id','asc')->get();
		//create new role
		$role = Role::find($id);
		Log::info($role->name." Role Added By ".auth()->user()->employee->full_name_en);
		$role['name']= $request->name;
		$role->save();
		//save newly created role authorities
		
		$role_id = Role::max('id');
		$counter =0;
		$count = count($pages);
		while($counter < $count){
			$RoleAuthority= RoleAuthority::where('role_id',$id)->where('page',$pages[$counter]['name'])->first();
			$RoleAuthority->role_id =$id;
			$RoleAuthority->page =$pages[$counter]['name'];
			if(isset($request->view[$counter])){
			$RoleAuthority->view =$request->view[$counter];
			}
			else{
				$RoleAuthority->view=0;
			}
			if(isset($request->modify[$counter])){
			$RoleAuthority->modify =$request->modify[$counter];
			}
			else{
				$RoleAuthority->modify=0;
			}
			if(isset($request->export[$counter])){
			$RoleAuthority->export =$request->export[$counter];
			}
			else{
				$RoleAuthority->export=0;
			}
			if(isset($request->view_only_employee_data[$counter])){
			$RoleAuthority->export =$request->view_only_employee_data[$counter];
			}
			else{
				$RoleAuthority->view_only_employee_data=0;
			}
			$RoleAuthority->save();
			$counter++;
		}
      return redirect("roles/index")->with('success', 'Role is successfully updated');
}
    /************** delet role *****************/
   public function delete($id)                      
    {
		$user =User::where('role_id',$id)->first();
		 //check if role has assigned users to it
		if($user != null){
		return back()->with('error', 'There is users related to this role ');
		}
		else{
        $role = Role::findOrFail($id);
        $role->delete();
		 $authorities = RoleAuthority::where('role_id',$id)->get();
		 foreach($authorities as $authority){
		 $authority->delete();
		 }
		}
        return back()->with('success', 'Role is successfully deleted');
    }
	
}