<?php

namespace App\Http\Controllers;
use App\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermissionExport;
use App\Exports\PermissionInsert;
use App\Imports\PermissionImport;
use DataTables;
use Log;
class PermissionController extends Controller
{
	public function index(Request $request){
	$permissions = Permission::all();
         if ($request->ajax()) {
     return Datatables::of($permissions)
     ->addIndexColumn()
	 ->addColumn('check_all', function($permission){

   $check_all = ' <input type="checkbox" class="checkbox" name="permission_ids[]" value="'.$permission->id.'"> ';

   return $check_all;
})
   ->addColumn('action', function($permission){
if(auth()->user()->authority('modify','permission_types')==1){
   $btn = ' <span class="edit-btn">
            <a href="permissions/edit/'.$permission->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="permissions/delete/'.$permission->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
}
})
->addColumn('is_paid', function($permission){
if($permission->is_paid ==1){
   return "Yes";
}
else{
	 return "No";
}
})

->rawColumns(['action','is_paid','check_all'])
->make(true);
}
      	return view('permissions.index');
	}
  /*** show create Permission page  ***/
	public function create(){
		 return view('permissions.create');
	}
	
	/****store permission data***/
	public function store(Request $request){
		$permission = new Permission;
		$permission['type']= $request->type;
		$permission['is_paid']= $request->is_paid;
		$permission->save();
		Log::info($request->type." Permission Added By ".auth()->user()->employee->full_name_en);
		return redirect("permissions/index")->with('success', 'permission is successfully added');
	}
	 /*** show edit permission page ***/
	public function edit($id)
   {
	 $permission= Permission::find($id);
     return view('permissions.edit',compact('permission'));
   }
   /************** update permission record in db  *****************/
	 public function update($id, Request $request)
   {
	   /**intializing user record that wanted to be updated ***/
        $permission= Permission::find($id);
		Log::info($permission->type." Permission updated By ".auth()->user()->employee->full_name_en);
	    $permission['type']= $request->type;
		$permission['is_paid']= $request->is_paid;
		$permission->save();
		
      return redirect("permissions/index")->with('success', 'permission is successfully updated');
}
    /************** delet permission *****************/
   public function delete($id)                      
    {
        $permission = Permission::findOrFail($id);
		Log::info($permission->type." Permission deleted By ".auth()->user()->employee->full_name_en);
        $permission->delete();
		
        return back()->with('success', 'permission is successfully deleted');
    }
	 public function deleteSelected(Request $request)
	{
      $permission_ids = $request->get('permission_ids');
        foreach($permission_ids as $id){
			$this->delete($id) ;
		}
      return redirect("permissions/index")->with('success', 'Selected Permissions Are Successfully Deleted');
    }
	 public function export()  
   {
	   return Excel::download(new PermissionExport , 'permission_import.xlsx');
	   Log::info("Permission File Exported By ".auth()->user()->employee->full_name_en);
	   return back()->with('success', 'Permissions are exported successfully');
   }
   /*******  export users excel sheet with heading to insert ***********/
	 public function export_insert() 
   {
	   return Excel::download(new PermissionInsert , 'Permission_Heading.xlsx');
	   Log::info("Permission Inserting File Exported By ".auth()->user()->employee->full_name_en);
	   return back();
   }
    /*******  import users excel sheet ***********/
	 public function import(Request $request)   
    {
	
        $this->validate($request, [
      'permission_import'  => 'required|mimes:xls,xlsx'
     ]);
	    
     Excel::import(new PermissionImport, request()->file('permission_import'));
	  Log::info("Permission File Imported By ".auth()->user()->employee->full_name_en);
     return back()->with('success', 'Excel Data Imported successfully.');
	
	}
	 
	
}