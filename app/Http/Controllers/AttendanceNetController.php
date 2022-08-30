<?php

namespace App\Http\Controllers;
use App\AttendanceNet;
use App\Employee;
use App\Attendance;
use App\Absence;
use App\vacation;
use App\OverTimeProfile;
use App\WorkScheduleProfile;
use App\EmployeeLeave;
use App\Leave;
use App\EmployeePermission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Log;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceNetExport;
use App\Exports\AttendanceNetExportInsert;
use App\Imports\AttendanceNetImport;
class AttendanceNetController extends Controller
{

    /*** show  Attendance page  ***/
    public function index(Request $request)
    {
         if ($request->ajax()) {
     $attendances = AttendanceNet::with('employee');
     return Datatables::of($attendances)
     ->addIndexColumn()
   ->addColumn('check_all', function($attendance){

   $check_all = ' <input type="checkbox" class="checkbox" name="attendance_ids[]" value="'.$attendance->id.'"> ';

   return $check_all;
})
 ->addColumn('delay_deduction', function($attendance){

  if($attendance->delay_deduction ==1){
	  $delay_deduction = "Yes";
  }
  else{
	  $delay_deduction = "NO";
  }

   return $delay_deduction;
})
   ->addColumn('action', function($attendance){
 if(auth()->user()->authority('modify','attendance_net_list')==1){
   $btn = '  <span class="delete-btn">
             <a href="attendance-net/delete/'.$attendance->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
 }
})
->addColumn('employee', function($attendance){

   return $attendance->employee->full_name_en;
})

->rawColumns(['action','employee','check_all','delay_deduction'])
->make(true);
}
      return view('attendance-net.index');
    }

public function create(){
		 $employees = Employee::orderBy('full_name_en','asc')->get();
		 return view('attendance-net.create',['employees'=>$employees]);
	}
	public function store(Request $request){

		$Attendance= new AttendanceNet;
		
		$Attendance['employee_id']= $request->employee_id;
		$Attendance['day']=$request->day;
		$Attendance['worked_duration']= $request->worked_duration;
		$Attendance['overtime_net_percentage']= $request->overtime_net_percentage;
		$Attendance['delay_minutes']= $request->delay_minutes;
		$Attendance->save();
		
		return redirect("attendance-net/index")->with('success', __('check-in-out.Employee Attendance added successfully'));

	}
	/*** show edit employee page ***/
	public function edit($id)
   {
      $attendance = AttendanceNet::findOrFail($id);
      $employees = Employee::orderBy('full_name_en','asc')->get();
		 return view('attendance-net.edit',['employees'=>$employees,'attendance'=>$attendance]);
   }
   public function update($id,Request $request){

		$attendance = AttendanceNet::findOrFail($id);
		
		$Attendance['employee_id']= $request->employee_id;
		$Attendance['day']=$request->day;
		$Attendance['worked_duration']= $request->worked_duration;
		$Attendance['overtime_net_percentage']= $request->overtime_net_percentage;
		$Attendance['delay_minutes']= $request->delay_minutes;
		$attendance->save();
		
		return redirect("attendance-net/index")->with('success',  __('check-in-out.Employee Attendance Added Successfully'));

	}
   public function deleteSelected(Request $request)
	{
      $attendance_ids = $request->get('attendance_ids');
        AttendanceNet::destroy($attendance_ids);
      return redirect("attendance-net/index")->with('success',  __('check-in-out.Selected Attendance Net Are Successfully Deleted'));
    }
	 public function delete($id)
	{
        AttendanceNet::destroy($id);
      return redirect("attendance-net/index")->with('success', __('check-in-out.Selected Attendance Net Are Successfully Deleted'));
    }
	 /*******  export attendance excel sheet ***********/
	public function export()
   {
	   return Excel::download(new AttendanceNetExport , 'attendance_net.xlsx');
	   return back()->with('success',  __('check-in-out.Attendance is exported successfully'));
   }
   // update all attendance net with new employee solde
     public function update_all(Request $request){
		 
		$employees = Employee::whereBetween('id', [91,140])->get();
		$months=[11,12,1,2,3,4,5,6];
		foreach($employees as $employee){
			foreach($months as $month){
	    Attendance::recalculateMonthDelay($employee->id,$month);
			}
		}
		
				
			
		return back()->with('success',  __('check-in-out.Employee Attendance Net Updated Successfully'));

	}
}
