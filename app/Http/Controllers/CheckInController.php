<?php

namespace App\Http\Controllers;
use App\Employee;
use App\Absence;
use App\Attendance;
use App\vacation;
use App\WorkScheduleProfile;
use App\EmployeeLeave;
use App\EmployeePermission;
use Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class CheckInController extends Controller
{
    /*** show ccheck/in/out page  ***/
    public function index(Request $request)
    {
        date_default_timezone_set("Africa/Cairo");
        $today_date = date('Y-m-d');
        $vacation = vacation::whereDate('from', '<=', date("Y-m-d"))
            ->whereDate('to', '>=', date("Y-m-d"))->first();

        if ($vacation != null) {
            session(["is_vacation" => 1]);
        }

        return view('check-in.index');
    }
	
	public function search(){
		
		return view('check-in.search');
		
	}
	public function get_employee(Request $request){
		if (!$request->code) {
        $html =  '';
    } else {
        $html = '';
		
        $employee = Employee::where('rfid_id',$request->code)->first();
        if ($employee) {
            $html =  '<div class="card">
              <h5 class="card-header table-header">Employee data</h5>
              <div class="card-body">
                  <div class="table-responsive">
				   <form action="'.url('check-in/store/'.$employee->id).'" method="POST">
				   '.csrf_field().'
                      <table class="table table-striped table-bordered first data-table" id="users-table">
                          <thead>

                              <tr>
                                  <th scope="col" class="img-title text-center">'.__("check-in-out.code").' </th>
                                  <th scope="col" class="product-name-title text-center">'. __("check-in-out.image").'</th>
                                  <th scope="col" class="category-title text-center">'. __("check-in-out.name").'</th>
								  <th scope="col" class="options-title text-center"></th>
                              </tr>
                          </thead>
                          <tbody>
						   <tr>
                                  <td scope="col" class="img-title text-center">'.$employee->code.'</td>
                                  <td scope="col" class="product-name-title text-center"><img src="'.asset('img/employees/'.$employee->image).'" class="circle-img"> </td>
                                  <td scope="col" class="category-title text-center">'.$employee->full_name_en.'</td>
								 <td scope="col" class="img-title text-center">
								 <span class="edit-btn">
								 <button type="submit"  class="btn btn-secondary import-btn" >'. __("check-in-out.check_in").' </button>
                                  </span>
								  </td>
                              </tr>
                          </tbody>
                      </table>
					   </form>
                  </div>
              </div>
			  
          </div>';
			
        }
    }

    return response()->json(['html' => $html]);
	}
	
	//save employee check in 
    public function store($id , Request $request){
		 //set time zone 
		date_default_timezone_set("Africa/Cairo");
		$employee = Employee::find($id);
		/*******check employee absence and delete it if exists ****/
		$absence_check = Absence::where('employee_id',$id)
				                          ->where('day',date('Y-m-d'))
										   ->first();
      
		 if($absence_check != null){
			$absence_check->delete(); 
		 }
		 /********************************************/
		
		  // check if employee checked in and didn't check out yet
	     $not_checked_out = Attendance ::where('employee_id',$id)
				                          ->where('day',date('Y-m-d'))
										  ->where('from','!=' ,null)
										  ->where('to',null)
										  ->first();
										  
		 if( $not_checked_out == null){
			 $employee = Employee::find($id);
			 $attendance = new Attendance ;
			 $attendance['employee_id']= $id;
		     $attendance['day']= date("Y-m-d");
		     $attendance['from']= date("H:i:s");
			 $attendance['work_schedule_id']= $employee->work_schedule_id;
			 $attendance['overtime_profile_id']= $employee->overtime_profile_id;
			  $attendance->save();
			 return back()->with('success', __("check-in-out.Employee check in  added successfully"));
		 }
		 else{
			  return back()->with('error',  __("check-in-out.Employee Has Not Checked Out Yet"));
		 }
		
}
} 