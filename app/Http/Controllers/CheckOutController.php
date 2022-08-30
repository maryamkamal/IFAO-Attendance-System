<?php

namespace App\Http\Controllers;
use App\Employee;
use App\Attendance;
use App\vacation;
use App\WorkScheduleProfile;
use App\OverTimeProfile;
use App\EmployeeLeave;
use App\AttendanceNet;
use Log;
use App\EmployeePermission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class CheckOutController extends Controller
{

	public function search(){

		return view('check-out.search');

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
				   <form action="'.url('check-out/store/'.$employee->id).'" method="POST">
				   '.csrf_field().'
                      <table class="table table-striped table-bordered first data-table" id="users-table">
                          <thead>

                              <tr>
                                  <th scope="col" class="img-title text-center">'. __("check-in-out.code").'</th>
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
								 <button type="submit"  class="btn btn-primary export-btn">'. __("check-in-out.check_out").' </button>
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

	//save employee check out
	public function store($employee_id , Request $request)
	{
		$employee = Employee::find($employee_id);
        date_default_timezone_set("Africa/Cairo");
		/***** check if employee assign net calculation or create new one***/
		$attendance_net = AttendanceNet::where('employee_id',$employee_id)
				                          ->where('day',date('Y-m-d'))
										  ->first();
		if($attendance_net == null){
			$attendance_net = new AttendanceNet;
			$attendance_net['employee_id'] = $employee_id ;
			$attendance_net['day'] = date('Y-m-d') ;
		}								 
		 /***********************************************************/
		/**** check if employee checked in ***/
		$checked_in = Attendance::where('employee_id',$employee_id)->where('day', date("Y-m-d"))->where('to',null)->orderBy('id', 'desc')->first();
		if($checked_in){
		  $checked_in['to']= date("H:i:s");
		  $checked_in['work_schedule_id']= $employee['work_schedule_id'];
		  $checked_in['overtime_profile_id']=  $employee['overtime_profile_id'];
           $checked_in->save();
		   $today_name = date('l', strtotime(date('Y-m-d')));
		//check employee working schedule
		
		$employee_schedule =WorkScheduleProfile::where('id',$checked_in->work_schedule_id)->first();
		$employee_overtime_profile = OverTimeProfile::where('id',$checked_in->overtime_profile_id)->first();
		// call attendance store function and set it's variables 
		Attendance::store($checked_in,$employee_id,date("Y-m-d"),$checked_in->from,date("H:i:s"),$employee_schedule->id,$employee_overtime_profile->id);
		return back()->with('success',  __("check-in-out.Employee check out  added successfully"));
    
		}
		//if employee already checked out
		else{
            return back()->with('error',__("check-in-out.Employee already checked out"));
        }
	}
}
