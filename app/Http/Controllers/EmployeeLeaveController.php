<?php

namespace App\Http\Controllers;
use App\EmployeePermission;
use App\leave;
use App\Employee;
use App\Absence;
use App\EmployeeLeave;
use App\vacation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeLeaveExport;
use App\Exports\EmployeeLeaveInsert;
use App\Imports\EmployeeLeaveImport;
use PDF;
use DataTables;
use Log;
class EmployeeLeaveController extends Controller
{

	public function index(Request $request){

	$employee_leaves = EmployeeLeave::with(['employee','leave']);
         if ($request->ajax()) {
     return Datatables::of($employee_leaves)
     ->addIndexColumn()
	->addColumn('check_all', function($employee_leave){

   $check_all = ' <input type="checkbox" class="checkbox" name="employee_leave_ids[]" value="'.$employee_leave->id.'"> ';

   return $check_all;
})
   ->addColumn('action', function($employee_leave){
if(auth()->user()->authority('modify','assign_employee_leave')==1){
   $btn = ' <span class="edit-btn">
            <a href="employee/leaves/edit/'.$employee_leave->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="employee/leaves/delete/'.$employee_leave->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
}
})

->addColumn('employee', function($employee_leave){
   return $employee_leave->employee->full_name_en;
})
->addColumn('leave', function($employee_leave){
   return $employee_leave->leave->type;
})
->rawColumns(['action','employee','check_all','leave'])
->make(true);
}
      	 return view('employee-leaves.index');
	}

	 /*** show create Leave page with vacations list table ***/
	public function create(Request $request){
	$employee_leaves = EmployeeLeave::paginate(10);
	$leaves = Leave::all();
	$employees = Employee::orderBy('full_name_en','asc')->get();
	return view('employee-leaves.create',['leaves'=>$leaves,'employees'=>$employees,'employee_leaves'=>$employee_leaves]);
	}
		/****store Leave data***/
	public function store(Request $request){
		$employee_leave = new EmployeeLeave;
		$employee_leave['employee_id']= $request->employee_id;
		$employee_leave['leave_id']= $request->leave_id;
		$employee_leave['from']= $request->from;
        $employee_leave['to']= $request->to;
		$employee_leave['status']= $request->status;
		$employee_leave['approved_by']= Auth::user()->id;
		$employee_leave->save();
         //delete old absences if exsist to start saving new updated absence
		   $employee = Employee::find($request->employee_id);
		  $absences =  Absence::where('employee_id',$request->employee_id)->whereBetween('day',[$request->from,$request->to])->get();
			if(count($absences) > 0){
				foreach($absences as $absence){
			      
		  $leave = Leave::find($absence->leave_id);
		 if($leave != null){
			         $leave_id = $leave->id;
					 if($leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance - $employee->work_schedule->work_duration ;
					 }
					 elseif($leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde + $employee->work_schedule->work_duration ;
					 }		 
		 }
		 else{
			  $employee->solde =  $employee->solde +  $employee->work_schedule->work_duration ;
		 }
		  $employee->save();
		  $absence->delete();
	
		 }
			}
			// saving new employees absence
		 $dates = array();
		 $format = 'Y-m-d';
      $current = strtotime($request->from);
      $date2 = strtotime($request->to);
      $stepVal = '+1 day';
      while( $current <= $date2 ) {
         $dates[] = date($format, $current);
         $current = strtotime($stepVal, $current);
      }
	   if($request->status =="approved"){
      foreach( $dates as $date){
		  date_default_timezone_set("Africa/Cairo");	
		   $day_name = date('l', strtotime($date));
		   $employee_schedule_days = unserialize($employee->work_schedule->work_days);
		   $vacation = vacation::whereDate('from', '<=',$date)
                             ->whereDate('to', '>=', $date)->first();
	 if(($vacation == null || ( $vacation->holiday_type != 0 && $vacation->holiday_type !=  $employee->holiday_type )) && in_array($day_name,$employee_schedule_days)){
		 $absence= new Absence;
		$absence['employee_id']= $request->employee_id;
		$absence['day']=$date;
		$absence['leave_id']=$request->leave_id;
		$absence['leave_status']="approved";
		$absence->save();
		Log::alert($employee->full_name_en."'s Absence For Day (".$date.") Added By  ".auth()->user()->employee->full_name_en);
		  $leave = Leave::find($request->leave_id);
		 if($leave != null && $request->status =="approved"){
			         $leave_id = $leave->id;
					 if($leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance + $employee->work_schedule->work_duration ;
					 }
					 elseif($leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde- $employee->work_schedule->work_duration ;
					 }       			 
		 }
		 else{
			  $employee->solde =  $employee->solde-  $employee->work_schedule->work_duration ;
			  
		 }
		 $employee->save();
		
	  }
	   }
	   }
		return redirect("employee/leaves/index")->with('success', __('employee-leaves.Employee leaves is successfully added'));
	}
	 /*** show edit Leave page ***/
	public function edit($id)
   {
	 $employee_leave= EmployeeLeave::find($id);
	 $leaves = Leave::all();
	 $employees = Employee::orderBy('full_name_en','asc')->get();
     return view('employee-leaves.edit',compact('employee_leave','leaves','employees'));
   }
   /************** update Leave record in db  *****************/
	 public function update($id, Request $request)
   {
	   /**intializing user record that wanted to be updated ***/
        $employee_leave= EmployeeLeave::find($id);
		$employee = Employee::find($request->employee_id);
		//delete old absence to start saving new updated absence
		$absences =  Absence::where('employee_id',$request->employee_id)->whereBetween('day',[$employee_leave->from,$employee_leave->to])->get();
			if(count($absences) > 0){
				foreach($absences as $absence){
			      
				
		  $leave = Leave::find($absence->leave_id);
		 if($leave != null){
			         $leave_id = $leave->id;
					 if($leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance - $employee->work_schedule->work_duration ;
					 }
					 elseif($leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde + $employee->work_schedule->work_duration ;
					 }		 
		 }
		 else{
			  $employee->solde =  $employee->solde +  $employee->work_schedule->work_duration ;
		 }
		  $employee->save();
		  $absence->delete();
		 }
			}
        //start saving new absence 
		 $dates = array();
		 $format = 'Y-m-d';
         $current = strtotime($request->from);
         $date2 = strtotime($request->to);
         $stepVal = '+1 day';
      while( $current <= $date2 ) {
         $dates[] = date($format, $current);
         $current = strtotime($stepVal, $current);
      }
	   if( $request->status =="approved"){
      foreach( $dates as $date){
		   date_default_timezone_set("Africa/Cairo");	
		   $day_name = date('l', strtotime($date));
		   $employee_schedule_days = unserialize($employee->work_schedule->work_days);
		   $vacation = vacation::whereDate('from', '<=',$date)
                             ->whereDate('to', '>=', $date)->first();
	 if(($vacation == null || ( $vacation->holiday_type != 0 && $vacation->holiday_type !=  $employee->holiday_type )) && in_array($day_name,$employee_schedule_days)){
		 $absence= new Absence;
		$absence['employee_id']= $request->employee_id;
		$absence['day']=$date;
		$absence['leave_id']=$request->leave_id;
		$absence['leave_status']="approved";
		$absence->save();
		  $leave = Leave::find($request->leave_id);
		 if($leave != null && $request->status =="approved"){
			         $leave_id = $leave->id;
					 if($leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance + $employee->work_schedule->work_duration ;
					 }
					 elseif($leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde- $employee->work_schedule->work_duration ;
					 }       			 
		 }
		 else{
			  $employee->solde =  $employee->solde-  $employee->work_schedule->work_duration ;
			   $employee->save();
		 }
		 $employee->save();
		
	  }
	   }
	   }
	   // start saving new employee leave data
	    $employee_leave['employee_id']= $request->employee_id;
		$employee_leave['leave_id']= $request->leave_id;
        $employee_leave['from']= $request->from;
        $employee_leave['to']= $request->to;
		$employee_leave['status']= $request->status;
	 	$employee_leave['approved_by']= Auth::user()->id;
	    $employee_leave->save();
      return redirect("employee/leaves/index")->with('success', __('employee-leaves.Leave is successfully updated'));
    } 
    /************** delet Leave *****************/
	
   public function delete($id)
    {
        $employee_leave = EmployeeLeave::findOrFail($id);
		$employee = Employee::find($employee_leave->employee_id);
		//delete old absence to start saving new updated absence
		$absences =  Absence::where('employee_id',$employee_leave->employee_id)->whereBetween('day',[$employee_leave->from,$employee_leave->to])->get();
			if(count($absences) > 0){
				foreach($absences as $absence){
			      $absence->delete();
				
		  $leave = Leave::find($absence->leave_id);
		 if($leave != null){
			         $leave_id = $leave->id;
					 if($leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance - $employee->work_schedule->work_duration ;
					 }
					 elseif($leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde + $employee->work_schedule->work_duration ;
					 }		 
		 }
		 else{
			  $employee->solde =  $employee->solde +  $employee->work_schedule->work_duration ;
		 }
		  $employee->save();
		 }
			}
        $employee_leave->delete();

        return back()->with('success',  __('employee-leaves.Leave is successfully deleted'));
    }
	 public function deleteSelected(Request $request)
	{
      $employee_leave_ids = $request->get('employee_leave_ids');
        foreach($employee_leave_ids as $id){
			$this->delete($id);
		}
       return back()->with('success', __('employee-leaves.Leave is successfully deleted'));
    }
    public function export()  
   {
	   return Excel::download(new EmployeeLeaveExport , 'employee_leaves_import.xlsx');
	   return back()->with('success',  __('employee-leaves.Employees Leaves are exported successfully'));
   }
   /*******  export users excel sheet with heading to insert ***********/
	 public function export_insert() 
   {
	   return Excel::download(new EmployeeLeaveInsert , 'Employee_Leave_Heading.xlsx');
	   return back();
   }
    /*******  import users excel sheet ***********/
	 public function import(Request $request)   
    {
	
        $this->validate($request, [
      'employee_leave_import'  => 'required|mimes:xls,xlsx'
     ]);
	    
     Excel::import(new EmployeeLeaveImport, request()->file('employee_leave_import'));
	 
     return back()->with('success',  __('employee-leaves.Excel Data Imported successfully.'));
	
	}
	/****store Leave data***/
	public function updateLeaveAbsence(){
		/*$employee_leaves =  EmployeeLeave::all();
         // saving employees absence
		 foreach($employee_leaves as $employee_leave){
		   $employee = Employee::find($employee_leave->employee_id);
		  $absences =  Attendance::where('employee_id',$employee_leave->employee_id)->whereBetween('day',[$employee_leave->from,$employee_leave->to])->get();
			if(count($absences) > 0){
				foreach($absences as $absence){
			      $absence->delete();
		 $leave = Leave::find($employee_leave->leave_id);
		 if($leave != null && $employee_leave->status =="approved"){
			         $leave_id = $leave->id;
					 if($leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance - $employee->work_schedule->work_duration ;
					 }
					 elseif($leave->solde_deduction != 1){
				     $employee->solde =  $employee->solde + $employee->work_schedule->work_duration ;
					 }  		 
		 }
		 else{
			  $employee->solde =  $employee->solde+  $employee->work_schedule->work_duration ;
		 }
		  $employee->save();
		 }
			}
		 $dates = array();
		 $format = 'Y-m-d';
      $current = strtotime($employee_leave->from);
      $date2 = strtotime($employee_leave->to);
      $stepVal = '+1 day';
      while( $current <= $date2 ) {
         $dates[] = date($format, $current);
         $current = strtotime($stepVal, $current);
      }
	  if( $employee_leave->status =="approved"){
      foreach( $dates as $date){
		   date_default_timezone_set("Africa/Cairo");	
		   $day_name = date('l', strtotime($date));
		   $employee_schedule_days = unserialize($employee->work_schedule->work_days);
		   $vacation = vacation::whereDate('from', '<=',$date)
                             ->whereDate('to', '>=', $date)->first();
	 if(($vacation == null || ( $vacation->holiday_type != 0 && $vacation->holiday_type !=  $employee->holiday_type )) && in_array($day_name,$employee_schedule_days)){
		 $absence= new Absence;
		$absence['employee_id']= $employee_leave->employee_id;
		$absence['day']=$date;
		$absence['leave_id']=$employee_leave->leave_id;
		$absence['leave_status']="approved";
		$absence->save();
		$leave = Leave::find($employee_leave->leave_id);
		 if($leave != null && $employee_leave->status =="approved"){
			         $leave_id = $leave->id;
					 if($leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance + $employee->work_schedule->work_duration ;
					 }
					 elseif($leave->solde_deduction != 1){
				     $employee->solde =  $employee->solde- $employee->work_schedule->work_duration ;
					 }			 
		 }
		 else{
			  $employee->solde =  $employee->solde -  $employee->work_schedule->work_duration ;
		 }
		  $employee->save();
	  }
	  }
	  }
		 }*/
		
			 $absences = Absence::all(); 
			foreach($absences as $absence){
				  date_default_timezone_set("Africa/Cairo");	
		   $day_name = date('l', strtotime($absence->day));
		   $employee = Employee::find($absence->employee_id);
		   $employee_schedule_days = unserialize($employee->work_schedule->work_days);
		    $vacation = vacation::whereDate('from', '<=',$absence->day)
                             ->whereDate('to', '>=', $absence->day)->first();
	 if( ( $vacation!= null && ($vacation->holiday_type == 0 || $vacation->holiday_type == $employee->holiday_type)) || !in_array($day_name,$employee_schedule_days)){
				 $leave = Leave::find($absence->leave_id);
		 if($leave != null){
			         $leave_id = $leave->id;
					 if($leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance - $employee->work_schedule->work_duration ;
					 }
					 elseif($leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde + $employee->work_schedule->work_duration ;
					 }		 
		 }
		 else{
			  $employee->solde =  $employee->solde +  $employee->work_schedule->work_duration ;
		 }
		  $employee->save();
		  $absence->delete();
				
			}				 
			  
		  }
		  
		return back()->with('success',  __('employee-leaves.leaves is successfully added To Absence'));
	}
    
}
