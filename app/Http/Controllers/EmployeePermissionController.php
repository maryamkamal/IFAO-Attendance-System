<?php

namespace App\Http\Controllers;
use App\Permission;
use App\Employee;
use App\EmployeePermission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeePermissionExport;
use App\Exports\EmployeePermissionInsert;
use App\Imports\EmployeePermissionImport;
use PDF;
use DataTables;
use Log;
class EmployeePermissionController extends Controller
{

  /*** show create Permission page with vacations list table ***/
	public function index(Request $request){

	$employee_permissions = EmployeePermission::with(['employee','permission']);
         if ($request->ajax()) {
     return Datatables::of($employee_permissions)
     ->addIndexColumn()
	 ->addColumn('check_all', function($employee_permission){

   $check_all = ' <input type="checkbox" class="checkbox" name="employee_permission_ids[]" value="'.$employee_permission->id.'"> ';

   return $check_all;
})
	 
   ->addColumn('action', function($employee_permission){
if(auth()->user()->authority('modify','assign_employee_permission')==1 ){
   $btn = ' <span class="edit-btn">
            <a href="employee/permissions/edit/'.$employee_permission->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="employee/permissions/delete/'.$employee_permission->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
}
})

->addColumn('employee', function($employee_permission){
   return $employee_permission->employee->full_name_en;
})
->addColumn('permission', function($employee_permission){
   return $employee_permission->permission->type;
})
->rawColumns(['action','employee','check_all','permission'])
->make(true);
}
      	 return view('employee-permissions.index');
	}
    public function create(){
	$permissions = Permission::all();
	$employees = Employee::orderBy('full_name_en','asc')->get();
		 return view('employee-permissions.create',['permissions'=>$permissions,'employees'=>$employees]);
	}
	/****store permission data***/
	public function store(Request $request){
		$employee_permission = new EmployeePermission;
		$employee_permission['employee_id']= $request->employee_id;
		$employee_permission['permission_id']= $request->permission_id;
		$employee_permission['day']= $request->day;
		$employee_permission['from']= $request->from;
		$employee_permission['to']= $request->to;
		$employee_permission['status']= $request->status;
		$employee_permission['approved_by']= Auth::user()->id;
		$employee_permission->save();
		Log::info("New Permission Request For Employee : ".Employee::find($request->employee_id)->full_name_en ." added by ".auth()->user()->employee->full_name_en);
		return redirect("employee/permissions/index")->with('success', 'Employee permissions is successfully added');
	}
	 /*** show edit permission page ***/
	public function edit($id)
   {
	 $employee_permission= EmployeePermission::find($id);
	 $permissions = Permission::all();
	 $employees = Employee::orderBy('full_name_en','asc')->get();
     return view('employee-permissions.edit',compact('employee_permission','permissions','employees'));
   }
   /************** update permission record in db  *****************/
	 public function update($id, Request $request)
   {
	   /**intializing user record that wanted to be updated ***/
        $employee_permission= EmployeePermission::find($id);
	    $employee_permission['employee_id']= $request->employee_id;
		$employee_permission['permission_id']= $request->permission_id;
		$employee_permission['day']= $request->day;
		$employee_permission['from']= $request->from;
		$employee_permission['to']= $request->to;
		$employee_permission['status']= $request->status;
		$employee_permission['approved_by']= Auth::user()->id;
		$employee_permission->save();
		Log::info("A Permission Request For Employee : ".Employee::find($request->employee_id)->full_name_en ." edited by ".auth()->user()->employee->full_name_en);
      return redirect("employee/permissions/index")->with('success', 'permission is successfully updated');
}

    /************** delet permission *****************/
   public function delete($id)
    {
        $employee_permissions = EmployeePermission::findOrFail($id);
		Log::info("A Permission Request For Employee : ".Employee::find($employee_permissions->employee_id)->full_name_en ." deleted by ".auth()->user()->employee->full_name_en);
        $employee_permissions->delete();

        return back()->with('success', 'permission is successfully deleted');
    }
	 public function deleteSelected(Request $request)
	{
      $employee_permission_ids = $request->get('employee_permission_ids');
	  foreach($employee_permission_ids as $id){
		  $this->delete($id);
	  }
        
      return back()->with('success', 'permission is successfully deleted');
    }
     public function export()  
   {
	   return Excel::download(new EmployeePermissionExport , 'employee_permissions.xlsx');
	   Log::info("A Permission Request File Exported by :".auth()->user()->employee->full_name_en);
	   return back()->with('success', 'Employees Permissions are exported successfully');
   }
   /*******  export permissions excel sheet with heading to insert ***********/
	 public function export_insert() 
   {
	   return Excel::download(new EmployeePermissionInsert , 'employee_permission_Heading.xlsx');
	   return back();
   }
    /*******  import users excel sheet ***********/
	 public function import(Request $request)   
    {
	
        $this->validate($request, [
      'employee_permission_import'  => 'required|mimes:xls,xlsx'
     ]);
	    
     Excel::import(new EmployeePermissionImport, request()->file('employee_permission_import'));
	 Log::info("A Permission Request File Imported by :".auth()->user()->employee->full_name_en);
     return back()->with('success', 'Excel Data Imported successfully.');
	
	}
    

}
