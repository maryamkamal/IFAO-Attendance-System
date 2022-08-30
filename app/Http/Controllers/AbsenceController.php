<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use App\Absence;
use App\Employee;
use App\Leave;
use App\vacation;
use App\EmployeeLeave;
use App\WorkScheduleProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsenceExport;
use App\Exports\AbsenceExportInsert;
use App\Imports\AbsenceImport;
use Artisan;
use Log;
class AbsenceController extends Controller
{

   public function index(Request $request)
    {
		//Artisan::call("absence:daily");
         if ($request->ajax()) {
     $absences = Absence::with('employee');
     return Datatables::of($absences)
     ->addIndexColumn()
   ->addColumn('check_all', function($absence){

   $check_all = ' <input type="checkbox" class="checkbox" name="absence_ids[]" value="'.$absence->id.'"> ';

   return $check_all;
})
->addColumn('leave', function($absence){
	if($absence->leave_id != null){
   return Leave::find($absence->leave_id)->type;
	}
	else {
		 return null;
	}
})
->addColumn('leave_status', function($absence){
	if($absence->leave_id != null){
   return "approved";
	}
})
   ->addColumn('action', function($absence){
    if(auth()->user()->authority('modify','absence_list')==1){
   $btn = ' <span class="delete-btn">
             <a href="absence/delete/'.$absence->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
	}
	
})

->addColumn('employee', function($absence){

   return $absence->employee->full_name_en;
})

->rawColumns(['action','employee','check_all','leave','leave_status'])
->make(true);
}
      return view('absence.index');
    }

public function create(){
		 $employees = Employee::orderBy('full_name_en','asc')->get();
		 return view('absence.create',['employees'=>$employees]);
	}
	public function store(Request $request){
        $employee = Employee::find($request->employee_id);
		$employee_schedule =WorkScheduleProfile::where('id', $employee->work_schedule->id)->first();
		date_default_timezone_set("Africa/Cairo");	
		   $day_name = date('l', strtotime($request->day));
		   $employee_schedule_days = unserialize($employee->work_schedule->work_days);
		   $vacation = vacation::whereDate('from', '<=',$request->day)
                             ->whereDate('to', '>=', $request->day)->first();
	 if(($vacation == null || ( $vacation->holiday_type != 0 && $vacation->holiday_type !=  $employee->holiday_type )) && in_array($day_name,$employee_schedule_days)){
		$EmployeeLeave=EmployeeLeave::where('employee_id',$employee->id)
				             ->whereDate('from', '<=',$request->day)
                             ->whereDate('to', '>=', $request->day)
							 ->where('status','approved')
							 ->first();
		 $leave_id =null;
		 if($EmployeeLeave != null){
			         $leave_id = $EmployeeLeave->leave_id;
					 if($EmployeeLeave->leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance + $employee_schedule->work_duration ;
					 }
					 elseif($EmployeeLeave->leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde - $employee_schedule->work_duration ;
					 }
		             $employee->save();
					 
		 }
		 else{
			  $employee->solde =  $employee->solde - $employee_schedule->work_duration ;
			  
		 }
		$absence= new Absence;
		$absence['employee_id']= $request->employee_id;
		$absence['day'] = $request->day;
		$absence['leave_id']=$leave_id;
		$absence->save();
		$employee->save();
		  Log::alert(Employee::find($request->employee_id)->full_name_en." Absence For Day (".$request->day.") Added By  ".auth()->user()->employee->full_name_en);
	 }
		return redirect("absence/index")->with('success', 'Employee Absence added successfully');

	}
	/*** show edit employee page ***/
	public function edit($id)
   {
      $absence = Absence::findOrFail($id);
      $employees = Employee::all();
		 return view('absence.edit',['employees'=>$employees,'absence'=>$absence]);
   }
  /* public function update($id,Request $request){

		$absence = Absence::findOrFail($id);
		
		$absence['employee_id']= $request->employee_id;
		$absence['day']=$request->day;
		$absence->save();
		
		return redirect("absence/index")->with('success', 'Employee Absence Added Successfully');

	}*/
	public function delete($id)
	{
		$absence =Absence::find($id);
		$employee = Employee::find($absence->employee_id);
		$employee_schedule =WorkScheduleProfile::where('id', $employee->work_schedule->id)->first();
		$EmployeeLeave=EmployeeLeave::where('employee_id',$employee->id)
				             ->whereDate('from', '<=',$absence->day)
                             ->whereDate('to', '>=', $absence->day)
							 ->where('status','approved')
							 ->first();
		 if($EmployeeLeave != null){
					 if($EmployeeLeave->leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance - $employee_schedule->work_duration ;
					 }
					 elseif($EmployeeLeave->leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde + $employee_schedule->work_duration ;
					 }
		             $employee->save();
					 
		 }
		 else{
			  $employee->solde =  $employee->solde + $employee_schedule->work_duration ;  
		 }
		 Log::alert(Employee::find($absence->employee_id)->full_name_en."'s Absence For Day (".$absence->day.") Deleted By  ".auth()->user()->employee->full_name_en);
		  Absence::destroy($id);
		$employee->save();
      return redirect("absence/index")->with('success', 'Selected Absence Successfully Deleted');
    }
   public function deleteSelected(Request $request)
	{
      $absence_ids = $request->get('absence_ids');
	  foreach($absence_ids as $id){
		  $this->delete($id);
	  }
        
      return back()->with('success', 'Selected Absences Are Successfully Deleted');
    }
	 /*******  export attendance excel sheet ***********/
	public function export()
   {
	   return Excel::download(new AbsenceExport , 'absence.xlsx');
	   return back()->with('success', 'Absence is exported successfully');
   }
   /*******  export attendance excel sheet with heading to insert ***********/
	 public function export_insert()
   {
	   return Excel::download(new AbsenceExportInsert , 'absence_heading.xlsx');
	   return back();
   }
    /*******  import attendance excel sheet ***********/
	 public function import(Request $request)
    {

        $this->validate($request, [
      'absence_import'  => 'required|mimes:xls,xlsx'
     ]);

     Excel::import(new AbsenceImport, request()->file('absence_import'));

     return back()->with('success', 'Excel Data Imported successfully.');

	}
    
}
