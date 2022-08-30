<?php

namespace App\Http\Controllers;
use Haruncpi\LaravelLogReader\LaravelLogReader;
use App\Attendance;
use App\AttendanceNet;
use App\Absence;
use App\Employee;
use App\EmployeeLeave;
use App\Leave;
use App\OverTimeProfile;
use App\WorkScheduleProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Log;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;
use App\Exports\AttendanceExportInsert;
use App\Exports\AttendanceExportUpdate;
use App\Imports\AttendanceInsertImport;
use App\Imports\AttendanceUpdateImport;

class AttendanceController extends Controller
{

  public function index(Request $request)
    {
		$employees = Employee::orderBy('full_name_en','asc')->get();
         if ($request->ajax()) {
         $attendances = Attendance::with(['employee','work_schedule','overtime_profile']);
		 return Datatables::of($attendances)
     ->addIndexColumn()
   ->addColumn('check_all', function($attendance){

  return $check_all = ' <input type="checkbox" class="checkbox" name="attendance_ids[]" value="'.$attendance->id.'"> ';

})
   ->addColumn('action', function($attendance){
  if(auth()->user()->authority('modify','attendance_list')==1){
   return  $btn = ' <span class="edit-btn">
            <a href="attendance/edit/'.$attendance->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="attendance/deleteAttendance/'.$attendance->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';
		 }
		 

})
->addColumn('employee', function($attendance){

   return $attendance->employee->full_name_en;
})
->addColumn('work_schedule', function($attendance){

   return $attendance->work_schedule->name;
   

})
->addColumn('overtime_profile', function($attendance){

 return $overtime_profile = $attendance->overtime_profile->name;

})
->addColumn('leave_type', function($attendance){
$absence = Absence::where('employee_id',$attendance->employee_id)->where('day',$attendance->day)->first();
if($attendance->work_schedule_id == 1 && $absence != null &&$absence->leave_id != null ){
   return Leave::find($absence->leave_id)->type;
}
})
->rawColumns(['action','employee','check_all','work_schedule','overtime_profile','leave_type'])
->make(true);
	 }

      return view('attendance.index',compact('employees'));
	 
    }
	 public function getAttendances()
    {
         $attendances = Attendance::select('employee_id','work_schedule_id','overtime_profile_id','day')->get();
		 return\response()->json($attendances);
		 }

    public function create(){
		  $employees = Employee::orderBy('full_name_en','asc')->get();
		  $overtime_profiles = OverTimeProfile::all();
          $work_schedules = WorkScheduleProfile::all();
		  return view('attendance.create',['employees'=>$employees,'overtime_profiles'=>$overtime_profiles,'work_schedules'=>$work_schedules]);
		  // abort(403, 'Unauthorized action.');
	}
	public function store(Request $request){
        $attendance = new Attendance;
		$employee_id =  $request->employee_id;
		$day=$request->day;
		$from= $request->from;
		$to= $request->to;
		$work_schedule_id = $request->work_schedule_id ;
		$overtime_profile_id = $request->overtime_profile_id ;
		// call attendance model store function 
	if($request->start != null && $request->end != null ){
		$dates = array();
		 $format = 'Y-m-d';
      $current = strtotime($request->start);
      $date2 = strtotime($request->end);
      $stepVal = '+1 day';
      while( $current <= $date2 ) {
         $dates[] = date($format, $current);
         $current = strtotime($stepVal, $current);
      }
	 
      foreach($dates as $date){
		// echo $date ."<br>";
		Attendance::store($attendance,$employee_id,$date,$from,$to,$work_schedule_id,$overtime_profile_id);
		Log::info(Employee::find($request->employee_id)->full_name_en." Attendance For Day (".$date.") Added By  ".auth()->user()->employee->full_name_en);
	  }
	  }
	  else{
		  Attendance::store($attendance,$employee_id,$day,$from,$to,$work_schedule_id,$overtime_profile_id);
		Log::info(Employee::find($request->employee_id)->full_name_en." Attendance For Day (".$day.") Added By  ".auth()->user()->employee->full_name_en);

}
		
		return redirect("attendance/index")->with('success', __("attendance.Employee Attendance added successfully"));

	}
	/*** show edit employee attendance page ***/
	public function edit($id)
   {
      $attendance = Attendance::findOrFail($id);
      $employees = Employee::orderBy('full_name_en','asc')->get();
	  $overtime_profiles = OverTimeProfile::all();
      $work_schedules = WorkScheduleProfile::all();
		 return view('attendance.edit',['employees'=>$employees,'attendance'=>$attendance,'overtime_profiles'=>$overtime_profiles,'work_schedules'=>$work_schedules]);
   }
   public function update($id,Request $request){
	   $attendance = Attendance::findOrFail($id);
	   $attendanceNet = AttendanceNet::where('employee_id',$attendance->employee_id)->where('day',$attendance->day)->first();
	    Attendance::restorDelayAndOvertime($attendance,$attendanceNet);
	   $employee = Employee::find($attendance->employee_id);
	   Log::info(Employee::find($employee->id)->full_name_en." Attendance For Day (".$attendance->day.") Updated By  ".auth()->user()->employee->full_name_en);
        $employee_id =  $request->employee_id;
		$day=$request->day;
		$from= $request->from;
		$to= $request->to;
		$work_schedule_id = $request->work_schedule_id ;
		$overtime_profile_id = $request->overtime_profile_id ;
	if($attendanceNet){
		 if($attendanceNet->delay > 0 || $attendanceNet->deducted_delay > 0  ){
			 $month = date('m',strtotime($attendance->day));
		    Attendance::recalculateMonthDelay($employee->id,$month);
			}
	}
		 Attendance::store($attendance,$employee_id,$day,$from,$to,$work_schedule_id,$overtime_profile_id);
		return redirect("attendance/index")->with('success',__("attendance.Employee Attendance Updated Successfully"));

	}
	
	//delete one attendance record
	 public function deleteAttendance($id)
	{
		 $this->delete($id);
		 return back()->with('success',__("attendance.Selected Attendances Are Successfully Deleted"));
	}
	public function delete($id)
	{
		 $attendance = Attendance::findOrFail($id);
		 $attendanceNet = AttendanceNet::where('employee_id',$attendance->employee_id)->where('day',$attendance->day)->first();
		 Attendance::restorDelayAndOvertime($attendance,$attendanceNet);
		 $employee = Employee::find($attendance->employee_id);
		 Log::info(Employee::find($employee->id)->full_name_en." Attendance For Day (".$attendance->day.") Deleted By  ".auth()->user()->employee->full_name_en);
		    Attendance::destroy($id);
			if($attendanceNet){
			if($attendanceNet->delay > 0 || $attendanceNet->deducted_delay > 0  ){
			$month = date('m',strtotime($attendance->day));
		    Attendance::recalculateMonthDelay($employee->id,$month);
			}
			 $attendanceNet->delete();
			}
    }
	//delete multiple records
   public function deleteSelected(Request $request)
	{
      $attendance_ids = $request->get('attendance_ids');
	  foreach($attendance_ids as $id){
		 $this->delete($id);   
	  }
	   return back()->with('success',__("attendance.Selected Attendances Are Successfully Deleted"));
    }
	 /*******  export attendance excel sheet ***********/
	public function export()
   {
	   return Excel::download(new AttendanceExport , 'attendance.xlsx');
	   return back()->with('success',__("attendance.Attendance is exported successfully"));
	   Log::info(" Attendance File Exported By ".auth()->user()->employee->full_name_en);
   }
   /*******  export attendance excel sheet with heading to insert ***********/
	 public function insertExport()
   {
	   return Excel::download(new AttendanceExportInsert , 'attendance_heading.xlsx');
	   return back();
   }
   /*******  export attendance excel sheet with heading to update ***********/
   public function updateExport(Request $request)
   {
	   session(['employee_id'=>$request->employee_id,'from'=>$request->from,'to'=>$request->to]);
	   if($request->employee_id != "all_employees"){
	   $sheet_name = Employee::find($request->employee_id)->full_name_en;
	   }
	   else{
		    $sheet_name = "update_employees";
	   }
	   	 Log::info(" Attendance File Exported By ".auth()->user()->employee->full_name_en);
	   return Excel::download(new AttendanceExportUpdate ,$sheet_name.'_attendance'.'.xlsx');
	   return back();
   }
    /*******  import attendance excel sheet ***********/
	 public function insertImport(Request $request)
    {

        $this->validate($request, [
      'attendance_insert_import'  => 'required|mimes:xls,xlsx'
     ]);

     Excel::import(new AttendanceInsertImport, request()->file('attendance_insert_import'));
     Log::info(" Attendance File Imported By ".auth()->user()->employee->full_name_en);
     return back()->with('success',__("attendance.Excel Data Imported successfully.") );

	}
	public function updateImport(Request $request)
    {

        $this->validate($request, [
      'attendance_update_import'  => 'required|mimes:xls,xlsx'
     ]);

     Excel::import(new AttendanceUpdateImport, request()->file('attendance_update_import'));
     Log::info(" Attendance File Imported By ".auth()->user()->employee->full_name_en);
     return back()->with('success',__("attendance.Excel Data Imported successfully."));

	}
    
}
