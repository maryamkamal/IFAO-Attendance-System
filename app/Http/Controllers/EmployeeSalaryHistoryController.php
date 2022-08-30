<?php

namespace App\Http\Controllers;
use App\Employee;
use App\OverTimeProfile;
use App\WorkScheduleProfile;
use App\EmployeeInputField;
use App\EmployeeSalaryHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeExport;
use App\Exports\EmployeeExportInsert;
use App\Imports\EmployeeImport;
use Redirect,Response;
 use DataTables;
 use PDF;
 use DB;
 use Log;
 use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
class EmployeeSalaryHistoryController extends Controller
{

  /*** return employee data in users list page with actions usind datatables libarary*****/
	public function index(Request $request){
    
  if ($request->ajax()) {
     $salaries = EmployeeSalaryHistory::orderBy('employee_id','asc')->get();
     return Datatables::of($salaries)
     ->addIndexColumn()
     ->addColumn('check_all', function($salary){

   $check_all = ' <input type="checkbox" class="checkbox" name="employees_salaries_ids[]" value="'.$salary->id.'"> ';

   return $check_all;
})

   ->addColumn('action', function($salary){
if(auth()->user()->authority('modify','employees')==1){
   $btn = ' <span class="edit-btn">
            <a href="employees/salaries/edit/'.$salary->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="employees/salaries/delete/'.$salary->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
}
})
   ->addColumn('employee', function($salary){

  return $salary->employee->full_name_en;

})
->rawColumns(['employee','action','check_all'])
->make(true);
}
      return view('employee-salary-history.index');
	}
	/*** show create employee page ***/
	public function create(){
		 $employees = Employee::orderBy('full_name_en','asc')->get();
		 return view('employee-salary-history.create',['employees'=>$employees]);
	}
	public function store(Request $request){

        $employee_salary = new EmployeeSalaryHistory;
		$employee_salary['employee_id']= $request->employee_id;
		$employee_salary['salary']= $request->salary;
		$employee_salary['start']= $request->start;
		$employee_salary['end']= $request->end ;
		$employee_salary->save();
		 Log::info("Employee Salary : ". Employee::find($request->employee_id)->full_name_en ."Salary Added By ".auth()->user()->employee->full_name_en);
		//redirect to employees list page after saving new employee
		return redirect("employees/salaries/index")->with('success', 'employee added successfully');

	}
	/*** show edit employee page ***/
	public function edit($id)
   {
         $employees = Employee::orderBy('full_name_en','asc')->get();
		 $employee_salary= EmployeeSalaryHistory::find($id);
		 return view('employee-salary-history.edit',['employees'=>$employees,'employee_salary'=>$employee_salary]);
   }
   /**update employee requested data**/
   public function update($id , Request $request)
   {
		$employee_salary= EmployeeSalaryHistory::find($id);
        Log::info("Employee: ". $employee_salary->employee->full_name_en ."Salary Updated By ".auth()->user()->employee->full_name_en);
		$employee_salary['employee_id']= $request->employee_id;
		$employee_salary['salary']= $request->salary;
		$employee_salary['start']= $request->start;
		$employee_salary['end']= $request->end ;
		$employee_salary->save();
       
	   return redirect("employees/salaries/index")->with('success', 'employee updated successfully');
   }

   public function delete($id)
    {
        $employee_salary = EmployeeSalaryHistory::findOrFail($id);
		Log::info("Employee: ". $employee_salary->employee->full_name_en ." Salary Deleted By ".auth()->user()->employee->full_name_en);
        $employee_salary->delete();

       return redirect("employees/salaries/index")->with('success', 'employee deleted successfully');
    }
	 /*******  delete all checked employees  ***********/
	public function deleteSelected(Request $request)
	{
      $employees_salaries_ids = $request->get('employees_salaries_ids');
        foreach($employees_salaries_ids as $id){
			$this->delete($id);
		}
      return redirect("employees/salaries/index")->with('success', 'Selected employees are successfully deleted');
    }
	 /*******  export employees excel sheet ***********/
	public function export()
   {
	   return Excel::download(new EmployeeExport , 'employees.xlsx');
	   Log::info("Employee File Exported By ".auth()->user()->employee->full_name_en);
	   return back()->with('success', 'employees are exported successfully');
   }
   /*******  export employees excel sheet with heading to insert ***********/
	 public function export_insert()
   {
	   return Excel::download(new EmployeeExportInsert , 'employees_heading.xlsx');
	    Log::info("Employee Inserting File Exported By ".auth()->user()->employee->full_name_en);
	   return back();
   }
    /*******  import employees excel sheet ***********/
	 public function import(Request $request)
    {

        $this->validate($request, [
      'employees_import'  => 'required|mimes:xls,xlsx'
     ]);
     
     Excel::import(new EmployeeImport, request()->file('employees_import'));
      Log::info("Employee File Imported By ".auth()->user()->employee->full_name_en);
     return back()->with('success', 'Excel Data Imported successfully.');

	}
	 /*******  print employee data in pdf file  ***********/
    public function print_pdf(){
        $input_fields = EmployeeInputField::select('name')->where('type', '!=' ,'file')->get();
        $static_inputs = ['full_name_en','code','work_schedule_profile_id','work_overtime_profile_id'];
        $dynamic_inputs = [];
        foreach($input_fields as $input_field){
            $dynamic_inputs[] = $input_field->name;
        }
        $all_inputs= array_merge($static_inputs,$dynamic_inputs);
        $employees=Employee::select($all_inputs)->orderBy('id')->get();
        $pdf = PDF::loadView('employees.pdf', compact('employees','all_inputs'));
	    Log::info("Employee PDF File Downloaded By ".auth()->user()->employee->full_name_en);
        return $pdf->download('employees.pdf');
}
}
