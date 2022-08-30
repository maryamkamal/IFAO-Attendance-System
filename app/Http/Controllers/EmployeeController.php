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
class EmployeeController extends Controller
{

  /*** return employee data in users list page with actions usind datatables libarary*****/
	public function index(Request $request){
     /*Artisan::call("cache:clear");
	 Artisan::call("view:clear");*/
  if ($request->ajax()) {
     $employees = Employee::orderBy('full_name_en','asc')->get();
     return Datatables::of($employees)
     ->addIndexColumn()
     ->addColumn('check_all', function($employee){

   $check_all = ' <input type="checkbox" class="checkbox" name="employee_ids[]" value="'.$employee->id.'"> ';

   return $check_all;
})
->addColumn('image', function($employee){

   $image = ' <img src="'.asset('img/employees/'.$employee->image).'" class="circle-img"> ';

   return $image;
})
   ->addColumn('action', function($employee){
if(auth()->user()->authority('modify','employees')==1){
   $btn = ' <span class="edit-btn">
            <a href="employees/edit/'.$employee->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="employees/delete_employee/'.$employee->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
}
})
->addColumn('overtime_profile', function($employee){

   $overtime_profile =$employee->overtime_profile->name ;
   return $overtime_profile;
})
->addColumn('work_schedule', function($employee){

   $work_scheduale = $employee->work_schedule->name ;
   return $work_scheduale;
})
->rawColumns(['action','check_all','image','overtime_profile','work_schedule'])
->make(true);
}
      return view('employees.index');
	}
	/*** show create employee page ***/
	public function create(){
		 $overtime_profiles = OverTimeProfile::all();
		  $work_schedules = WorkScheduleProfile::all();
		  $input_fields = EmployeeInputField::all();
		 return view('employees.create',['work_schedules'=>$work_schedules,'overtime_profiles'=>$overtime_profiles,'input_fields'=>$input_fields]);
	}
	public function store(Request $request){

        $input_fields = EmployeeInputField::all();
		$employee= new Employee;
		foreach($input_fields as $input_field){
		$name=$input_field->name;
		if($input_field->type == "file" &&  $request->file($input_field->name) != null){
		 $file = $request->file($input_field->name) ;
		 $extension = $file->getClientOriginalExtension();
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('employees-files'), $fileName);
			$employee[$name] =  $fileName;
		}
		else{
		$employee[$name]=$request->input($name);

		   }
		}
		$employee['full_name_en']= $request->full_name_en;
		$employee['code']=$request->code;
		$employee['work_overtime_profile_id']= $request->overtime_profile_id;
		$employee['work_schedule_profile_id']= $request->work_schedule_id;
		$employee['salary']= $request->salary;
		$employee['salary_start']= $request->salary_start;
		$employee['hourly_labor_cost']= $request->salary/(30*8) ;
		$employee['solde']= $request->solde;
		$employee['delay_balance']= $request->delay_balance;
		$employee['holiday_type']= $request->holiday_type;
		$employee['rfid_id']= $request->rfid_id;
		if($request->image) {
            $fileName = $request->full_name_en;
            $extension = $request->image->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->image->move(public_path('img/employees'), $fileName);
			$employee['image']= $fileName;
		 }
		$employee->save();
		 Log::info("Employee: ". $request->full_name_en ." Added By ".auth()->user()->employee->full_name_en);
		//redirect to employees list page after saving new employee
		return redirect("employees/index")->with('success', 'employee added successfully');

	}
	/*** show edit employee page ***/
	public function edit($id)
   {
     $employee = Employee::findOrFail($id);
	 $overtime_profiles = OverTimeProfile::all();
     $work_schedules = WorkScheduleProfile::all();
     $input_fields = EmployeeInputField::all();
		 return view('employees.edit',['work_schedules'=>$work_schedules,'overtime_profiles'=>$overtime_profiles,'input_fields'=>$input_fields,'employee'=> $employee]);
   }
   /**update employee requested data**/
   public function update($id , Request $request)
   {
	   $input_fields = EmployeeInputField::all();
		$employee= Employee::find($id);
        Log::info("Employee: ". $employee->full_name_en ." Updated By ".auth()->user()->employee->full_name_en);
		foreach($input_fields as $input_field){
		$name=$input_field->name;
		if($input_field->type == "file" &&  $request->file($input_field->name) != null){
		 $file = $request->file($input_field->name) ;
		 $extension = $file->getClientOriginalExtension();
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('employees-files'), $fileName);
			$employee[$name] =  $fileName;
		}
		else{
		$employee[$name]=$request->input($name);

		   }
		}
		$employee['full_name_en']= $request->full_name_en;
		$employee['code']=$request->code;
		$employee['work_overtime_profile_id']= $request->overtime_profile_id;
		$employee['work_schedule_profile_id']= $request->work_schedule_id;
		$employee['hourly_labor_cost']=  $request->salary/(30*8) ;
		$employee['solde']= $request->solde;
		$employee['delay_balance']= $request->delay_balance;
		$employee['holiday_type']= $request->holiday_type;
		$employee['rfid_id']= $request->rfid_id;
		if($request->image) {
            $fileName = $request->full_name_en;
            $extension = $request->image->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->image->move(public_path('img/employees'), $fileName);
			$employee['image']= $fileName;
		 }
		 //if salary updated then save old salary in employee salary history
		if( $employee->salary != $request->salary){
		$employee_salary_history = new	EmployeeSalaryHistory ;
		$employee_salary_history['employee_id'] = $employee->id ;
		$employee_salary_history['salary'] = $request->salary ;
		if($employee->salary_start!= null){
		$employee_salary_history['start'] = $employee->salary_start ;
		}
		else{
		$employee_salary_history['start'] = $employee->created_at ;
		}
		$employee_salary_history['end'] =  date( 'Y-m-d', strtotime( $request->salary_start . ' -1 day' ) );
		$employee_salary_history->save();
		}
		$employee['salary']= $request->salary;
		$employee['salary_start']= $request->salary_start;
		$employee->save();
       
	   return redirect("employees/index")->with('success', 'employee updated successfully');
   }
   // delete employee image
   public function deleteImage($id)
    {
        $employee = Employee::findOrFail($id);
		unlink('img/employees/'.$employee->image);
        $employee->image = null;
        $employee->save();

       return back()->with('success', 'employee image deleted successfully');
    }
   public function deleteEmployee($id)
    {
        $employee = Employee::findOrFail($id);
		Log::info("Employee: ". $employee->full_name_en ." Deleted By ".auth()->user()->employee->full_name_en);
        $employee->delete();

       return redirect("employees/index")->with('success', 'employee deleted successfully');
    }
	 /*******  delete all checked employees  ***********/
	public function deleteSelected(Request $request)
	{
      $employee_ids = $request->get('employee_ids');
        foreach($employee_ids as $id){
			$this->deleteEmployee($id);
		}
      return redirect("employees/index")->with('success', 'Selected employees are successfully deleted');
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
