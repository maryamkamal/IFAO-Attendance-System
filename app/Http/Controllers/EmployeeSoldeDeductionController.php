<?php

namespace App\Http\Controllers;
use App\Permission;
use App\Employee;
use App\EmployeeSoldeDeduction;
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
class EmployeeSoldeDeductionController extends Controller
{

  /*** show create Permission page with vacations list table ***/
	public function index(Request $request){

	$EmployeeSoldeDeductions = EmployeeSoldeDeduction::with(['employee','deducted_by']);
         if ($request->ajax()) {
     return Datatables::of($EmployeeSoldeDeductions)
     ->addIndexColumn()
	 ->addColumn('check_all', function($EmployeeSoldeDeduction){

   $check_all = ' <input type="checkbox" class="checkbox" name="EmployeeSoldeDeductionIds[]" value="'.$EmployeeSoldeDeduction->id.'"> ';

   return $check_all;
})
	 
   ->addColumn('action', function($EmployeeSoldeDeduction){
if(auth()->user()->authority('modify','assign_employee_permission')==1 ){
   $btn = ' <span class="edit-btn">
            <a href="employee/solde/deduction/edit/'.$EmployeeSoldeDeduction->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="employee/solde/deduction/delete/'.$EmployeeSoldeDeduction->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
}
})

->addColumn('employee', function($EmployeeSoldeDeduction){
   return $EmployeeSoldeDeduction->employee->full_name_en;
})
->addColumn('deducted_by', function($EmployeeSoldeDeduction){
   return Employee::find($EmployeeSoldeDeduction->deducted_by)->full_name_en ;
})
->rawColumns(['action','employee','check_all','deducted_by'])
->make(true);
}
      	 return view('employees-solde-deduction.index');
	}
    public function create(){
	$employees = Employee::orderBy('full_name_en','asc')->get();
		 return view('employees-solde-deduction.create',['employees'=>$employees]);
	}
	/****store permission data***/
	public function store(Request $request){
		$EmployeeSoldeDeduction = new EmployeeSoldeDeduction;
		$EmployeeSoldeDeduction['employee_id']= $request->employee_id;
		$EmployeeSoldeDeduction['deducted_solde']= $request->deducted_solde;
		$EmployeeSoldeDeduction['note']= $request->note;
		$EmployeeSoldeDeduction['deducted_by']= auth()->user()->employee->id;
		$EmployeeSoldeDeduction->save();
		$this->deductSold($request->employee_id,$request->deducted_solde);
		Log::info(auth()->user()->employee->full_name_en." Deduct". $request->deducted_solde . " Hours From Employee : ". Employee::find($request->employee_id)->full_name_en."'s Solde ");
		return redirect("employee/solde/deduction/index")->with('success', 'Employee Solde Is Deducted successfully');
	}
	 /*** show edit permission page ***/
	public function edit($id)
   {
	 $EmployeeSoldeDeduction= EmployeeSoldeDeduction::find($id);
	 $employees = Employee::orderBy('full_name_en','asc')->get();
     return view('employees-solde-deduction.edit',compact('EmployeeSoldeDeduction','employees'));
   }
   /************** update permission record in db  *****************/
	 public function update($id, Request $request)
   {
	   /**intializing user record that wanted to be updated ***/
        $EmployeeSoldeDeduction= EmployeeSoldeDeduction::find($id);
		$this->restoreDeductedSold($EmployeeSoldeDeduction->employee_id,$EmployeeSoldeDeduction->deducted_solde);
		$EmployeeSoldeDeduction['employee_id']= $request->employee_id;
		$EmployeeSoldeDeduction['deducted_solde']= $request->deducted_solde;
		$EmployeeSoldeDeduction['note']= $request->note;
		$EmployeeSoldeDeduction['deducted_by']= auth()->user()->employee->id;
		$EmployeeSoldeDeduction->save();
		$this->deductSold($request->employee_id,$request->deducted_solde);
		
		Log::info(auth()->user()->employee->full_name_en." Deduct". $request->deducted_solde . " Hours From Employee : ". Employee::find($request->employee_id)->full_name_en."'s Solde ");
      return redirect("employee/solde/deduction/index")->with('success', 'Employee Solde Deduction Is Successfully Updated');
}

    /************** delet permission *****************/
   public function delete($id)
    {
        $EmployeeSoldeDeduction = EmployeeSoldeDeduction::findOrFail($id);
		$this->restoreDeductedSold($EmployeeSoldeDeduction->employee_id,$EmployeeSoldeDeduction->deducted_solde);
		Log::info(auth()->user()->employee->full_name_en." Restore Deducted". $EmployeeSoldeDeduction->deducted_solde . " Hours To Employee : ". Employee::find($EmployeeSoldeDeduction->employee_id)->full_name_en."'s Solde ");
        $EmployeeSoldeDeduction->delete();

        return back()->with('success', 'permission is successfully deleted');
    }
	 public function deleteSelected(Request $request)
	{
      $EmployeeSoldeDeductionIds = $request->get('EmployeeSoldeDeductionIds');
	  foreach($EmployeeSoldeDeductionIds as $id){
		  $this->delete($id);
	  }
        
      return back()->with('success', 'Solde Deduction is successfully deleted');
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
    public function restoreDeductedSold($id,$restored_sold){
		$employee = Employee::find($id);
		$employee->solde = $employee->solde +$restored_sold ;
		$employee->save();
	}
	 public function deductSold($id,$deducted_sold){
		$employee = Employee::find($id);
		$employee->solde = $employee->solde - $deducted_sold ;
		$employee->save();
	}
    

}
