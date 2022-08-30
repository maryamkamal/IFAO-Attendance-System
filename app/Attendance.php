<?php

namespace App;

use App\Employee;
use App\Absence;
use App\vacation;
use App\OverTimeProfile;
use App\WorkScheduleProfile;
use App\EmployeeLeave;
use App\Leave;
use Log;
use Illuminate\Database\Eloquent\Model;
class Attendance extends Model
{
	protected $fillable = ['day','employee_id','from','to'];
    public function employee()
  {
    return $this->belongsTo(Employee::class, 'employee_id');
  }
   public function overtime_profile()
  {
    return $this->belongsTo(OverTimeProfile::class,'overtime_profile_id');
  }
   public function work_schedule()
  {
    return $this->belongsTo(WorkScheduleProfile::class,'work_schedule_id');
  }
  
 public static function store($attendance,$employee_id,$day,$from,$to,$work_schedule_id,$overtime_profile_id)
  {
        date_default_timezone_set("Africa/Cairo");	
		 $today_name = date('l', strtotime($day));
		 $vacation = vacation::whereDate('from', '<=',$day)
                             ->whereDate('to', '>=', $day)->first();
		$employee = Employee::find($employee_id);
      
		$attendance_net = AttendanceNet::where('employee_id',$employee_id)
				                          ->where('day', $day)
										  ->first();
					
	            	if($attendance_net == null){
		        	$attendance_net = new AttendanceNet;
		           }
                    $attendance_net['employee_id'] = $employee_id ;
			        $attendance_net['day'] = $day;	
					
			/*************************************************************************/
        if($day != null && $work_schedule_id !=1){
			//save attendance
        $attendance['employee_id']= $employee_id;
		$attendance['day']=$day;
		$attendance['from']= $from;
		$attendance['to']= $to;
		$attendance['work_schedule_id']= $work_schedule_id;
		$attendance['overtime_profile_id']= $overtime_profile_id;
		$attendance->save();	
       Log::info(Employee::find($employee_id)->full_name_en." Attendance For Day (".$day.") Added By  ".auth()->user()->employee->full_name_en);	
	 /** delete employee's absence if exsists ***/
	   $employee_absence =  Absence::where('employee_id',$employee_id)->where('day',$day)->first();
	   if( $employee_absence != null){
		    $employee_absence->delete();
			$EmployeeLeave=EmployeeLeave::where('employee_id',$employee->id)
				             ->whereDate('from', '<=',$day)
                             ->whereDate('to', '>=', $day)
							 ->where('status','approved')
							 ->first();
		  $employee_basic_schedule = WorkScheduleProfile::where('id', $employee->work_schedule->id)->first();        
		  if($EmployeeLeave != null){
					 if($EmployeeLeave->leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde + $employee_basic_schedule->work_duration ;
					 } 
		 }
		 else{
			 $employee->solde =  $employee->solde + $employee_basic_schedule->work_duration ;
		 }
		 $employee->save();
	   }
			
		         //check employee working schedule
		         $employee_schedule =WorkScheduleProfile::where('id',$work_schedule_id)->first();
		         $employee_overtime_profile = OverTimeProfile::where('id',$overtime_profile_id)->first();
		         $employee_schedule_days = unserialize($employee_schedule->work_days);
		         $employee_work_hour_cost = $employee->salary /(30*8);
       	
			/*************************** case employee has check in /check out data *********************/
			if( $from != null && $to != null){
	   
				/************************* start net calculations **********************************/
		         
		       /*** get all checkd in/out of the day *****/	
                			   
		        $employee_check_in_of_the_day =Attendance::where('employee_id',$employee_id)->where('day', $day)
				                                                                             ->where('from','!=',null)
																							  ->where('to','!=',null)->get();
		        $total_worked_hours = 0 ;
		        foreach( $employee_check_in_of_the_day as $checked_net){
					// case employee work at PM hours to AM hours
                 if(floor((strtotime($checked_net->to)-strtotime($checked_net->from))/60) < 0){
					 
				 $net =((12*60)-(floor((strtotime($checked_net->from)-strtotime('12:00:00'))/60)))+(floor((strtotime($checked_net->to)-strtotime('00:00:00'))/60)); 
				 }
				 else{
		        $net = floor((strtotime($checked_net->to)-strtotime($checked_net->from))/60);
				 }
		        $total_worked_hours = $net + $total_worked_hours;
				
         	    }
			   //set attendance net of all checked in/out of the day = total net
				$attendance_net['worked_duration'] = round(($total_worked_hours/60),2);
				// if employee overtime > employee cumulative delay
		       if($employee_overtime_profile != null) {
				   //get employee delay and deducted delay of the month to check if employee still has old delay
				   $EmplyeeAttendanceNet =  AttendanceNet::select('delay','deducted_delay')->where('employee_id',$employee_id)->whereMonth('day',date('m',strtotime($day)))->whereYear('day',date('Y',strtotime($day)))->where('day','<',$day)->get();
				 $employee_previous_delay = $EmplyeeAttendanceNet->sum('delay') ;
				 $employee_deducted_delay =$EmplyeeAttendanceNet->sum('deducted_delay') ;
				 $employee_final_delay = $employee_previous_delay -$employee_deducted_delay ;
		    	// delay and overtime calculations for weekends and vacations 	
                 if($employee_final_delay > 0){
				   $attendance_net['delay_deduction']=1;
				   $overtime = ($total_worked_hours / 60) - $employee_final_delay ;
				   //if employee work hours more than delay hours
				   if($overtime > 0){
					   //deducte all old delay 
					   $attendance_net['deducted_delay']=  round($employee_final_delay,2);
					   $final_overtime = $overtime ;
					   $employee->delay_balance = $employee->delay_balance - round($employee_final_delay,2) ;
				   }
				   //if worked hours less than old delay 
				   else{
					   //deducte all worked hours
					    $attendance_net['deducted_delay'] =  round(($total_worked_hours / 60),2);
					   $final_overtime = null ;
					   $employee->delay_balance = $employee->delay_balance - round(($total_worked_hours / 60),2) ;
				   }
				   $employee->save();
				   }
				   else{
					   $final_overtime = $total_worked_hours / 60;
				   }
				/*********************************************calculate overtime hours in weekends*******************************************/
		     if(!in_array($today_name,$employee_schedule_days) && $vacation == null){
				
			   $attendance_net['delay']=null;
			    $attendance_net['final_overtime_hours'] = round($final_overtime,2) ;
                $attendance_net['overtime_net_percentage'] =round(($final_overtime) *($employee_overtime_profile->weekend_days_time_ratio / 100),2);
			    $employee->overtime_hours =  $employee->overtime_hours + round(($final_overtime) *($employee_overtime_profile->weekend_days_time_ratio / 100),2);
				$attendance_net['overtime_bonus'] =  round($employee_work_hour_cost *($final_overtime * ($employee_overtime_profile->weekend_days_bonus_ratio / 100)),2);
			 }
			
	       /************************************ vacation days calculations ****************************************/
	       if($vacation != null){
			 
			$attendance_net['delay']=null;
			$attendance_net['final_overtime_hours'] = round($final_overtime,2) ;
		    $attendance_net['overtime_net_percentage'] = round(($final_overtime ) * ($employee_overtime_profile->holidays_time_ratio / 100),2);
            $employee->overtime_hours =  $employee->overtime_hours +round(($final_overtime ) * ($employee_overtime_profile->holidays_time_ratio / 100),2);
			$attendance_net['overtime_bonus'] =   round($employee_work_hour_cost * ($final_overtime  * ($employee_overtime_profile->holidays_bonus_ratio / 100)),2);
	       }
		   
		   /******************************************************************* start working days calculations **************************************/
		   if(in_array($today_name,$employee_schedule_days) && $vacation == null){
			   $worked_overtime_hours = ($total_worked_hours / 60) - $employee_schedule->work_duration;
			    $final_overtime = 0 ;
				//if there is worked overtime
			   if($worked_overtime_hours > 0){
				   if($employee_final_delay > 0){
				   $attendance_net['delay_deduction']=1;
				   $deducted_overtime_hours = $worked_overtime_hours - $employee_final_delay ;
				   //if employee overtime more than delay hours
				   if($deducted_overtime_hours > 0){
					   //deducte all old delay 
					   $attendance_net['deducted_delay']=  round($employee_final_delay,2);
					   $final_overtime = $deducted_overtime_hours ;
					   $employee->delay_balance = $employee->delay_balance - round($employee_final_delay,2) ;
				   }
				   //if worked hours less than old delay 
				   else{
					   //deducte all overtime hours
					    $attendance_net['deducted_delay'] =  round($worked_overtime_hours,2);
					   $final_overtime = null ;
					   $employee->delay_balance = $employee->delay_balance - round($worked_overtime_hours,2) ;
				   }
				   $employee->save();
				   }
				   else{
					   $final_overtime = $worked_overtime_hours;
				   }
				
			}
			else{
				  $final_overtime = $worked_overtime_hours;
			}

		   //if over time hours < 2
                if(0 < $final_overtime && $final_overtime <= 2){
				$attendance_net['delay'] = null ;
				$attendance_net['final_overtime_hours'] =  round($final_overtime,2) ;
                $attendance_net['overtime_net_percentage'] = round($final_overtime *( $employee_overtime_profile->first_two_hours_time_ratio / 100),2);
				$employee->overtime_hours =  $employee->overtime_hours + round($final_overtime *( $employee_overtime_profile->first_two_hours_time_ratio / 100),2);
			    $attendance_net['overtime_bonus'] =  round( $employee_work_hour_cost*($final_overtime *( $employee_overtime_profile->first_two_hours_bonus_ratio / 100)),2) ;
				}
			//more than 2 hours
			   elseif($final_overtime > 2){
				$attendance_net['delay'] = null ;
				$attendance_net['final_overtime_hours'] =  round($final_overtime,2) ;
				//percentage = first 2 hours percentage + latest hours percentage
			 	$attendance_net['overtime_net_percentage']= round((2*($employee_overtime_profile->first_two_hours_time_ratio / 100)) +(($final_overtime -2)*($employee_overtime_profile->next_hours_time_ratio/100)),2);
			    $employee->overtime_hours =  $employee->overtime_hours + round((2*($employee_overtime_profile->first_two_hours_time_ratio / 100)) +(($final_overtime -2)*($employee_overtime_profile->next_hours_time_ratio/100)),2);
			    $attendance_net['overtime_bonus'] = round($employee_work_hour_cost * ((2*($employee_overtime_profile->first_two_hours_bonus_ratio / 100)) +(($final_overtime -2)*($employee_overtime_profile->next_hours_bonus_ratio/100))),2);
			   }
			   elseif($final_overtime == 0){
				    $attendance_net['delay'] = null ;
					$attendance_net['final_overtime_hours'] =null  ;
				    $attendance_net['overtime_net_percentage']= null;
				    $attendance_net['overtime_bonus'] = null;
			   }
		   
		//delay case
			if( $worked_overtime_hours < 0){ 
			//if employee has permission of delay 
			$EmployeePermission = EmployeePermission::where('employee_id',$employee->id)
			->where('day',$day)
			->where('status','approved')
			->join('permissions', 'permissions.id', '=', 'employee_permissions.permission_id')
			->select('employee_permissions.from','employee_permissions.to','permissions.is_paid','employee_permissions.status')
            ->first();
			   if($EmployeePermission != null){
				    $permission_duration =strtotime($EmployeePermission->to)/60-strtotime($EmployeePermission->from)/60;
					if( ($permission_duration/60) < -$worked_overtime_hours){
						$attendance_net['delay'] =  round(-$worked_overtime_hours -($permission_duration/60),2);
				        $employee->delay_balance = $employee->delay_balance +(-$worked_overtime_hours -($permission_duration/60)) ;
					}
			    }
			  else{
				   $attendance_net['delay'] =  round(-$worked_overtime_hours,2) ;
				   $employee->delay_balance = $employee->delay_balance - $worked_overtime_hours ;
	            }
				  $attendance_net['final_overtime_hours'] =null  ;
				  $attendance_net['overtime_net_percentage']= null;
				  $attendance_net['overtime_bonus'] = null;
				  $attendance_net['deducted_delay'] = null;
				  $attendance_net['delay_deduction']=0;
		   }
		}
		}
		$attendance_net->save();
		 $employee->save();
	}
	//case missions or working remotely profiles without assign attendance time 
	//on updating attendance case 
	elseif($from == null && $to == null){
		
		$attendance_net['worked_duration'] = $employee_schedule->work_duration ;
		$attendance_net['delay']=null;
		$attendance_net['delay_deduction']=0;
		$attendance_net['final_overtime_hours'] =null  ;
		$attendance_net['deducted_delay'] = null ;
        $attendance_net['overtime_net_percentage'] = null;	
		$attendance_net['overtime_bonus'] = null;
		$attendance_net->save();
      
		
}
  }
   // absence case 
		elseif( $work_schedule_id == 1 ){
			$absence =  Absence::where('employee_id',$employee_id)->where('day',$day)->first();
			$employee_schedule =WorkScheduleProfile::where('id',$employee->work_schedule->id)->first();
		    $employee_schedule_days = unserialize($employee_schedule->work_days);
			$attendanceNet_of_day = AttendanceNet::where('employee_id',$employee_id)->where('day',$day)->first();
	    	if( $attendanceNet_of_day != null){
			$attendanceNet_of_day->delete();
		   }
	    //if there is no vacations or weekend store employee absence
		if($absence == null && $vacation == null && in_array($today_name,$employee_schedule_days)){
			//save attendance as absent profile
		$attendance['employee_id']= $employee_id;
		$attendance['day']=$day;
		$attendance['from']= $from;
		$attendance['to']= $to;
		$attendance['work_schedule_id']= $work_schedule_id;
		$attendance['overtime_profile_id']= $overtime_profile_id;
		$attendance->save();
        Log::info(Employee::find($employee_id)->full_name_en." Attendance For Day (".$day.") Added By  ".auth()->user()->employee->full_name_en);		
		        $EmployeeLeave=EmployeeLeave::where('employee_id',$employee->id)
				             ->whereDate('from', '<=',$day)
                             ->whereDate('to', '>=', $day)
							 ->where('status','approved')
							 ->first();
		             $leave_id =null;
					 $leave_status = null;
		  if($EmployeeLeave != null){
			         $leave_id = $EmployeeLeave->leave_id;
					  $leave_status = "approved";
					 if($EmployeeLeave->leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance + $employee_schedule->work_duration ;
					 }
					 elseif($EmployeeLeave->leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde - $employee_schedule->work_duration ;
					 } 
		 }
		 else{
			 $employee->solde =  $employee->solde- $employee_schedule->work_duration ;
		 }
		 $absence= new Absence;
		$absence['employee_id']= $employee_id;
		$absence['day']=$day;
		$absence['leave_id']=$leave_id;
		$absence['leave_status']=$leave_status;
		$absence->save();
		$employee->save();
		Log::alert($employee->full_name_en."'s Absence For Day (".$day.") Added By  ".auth()->user()->employee->full_name_en);
		}
		//if employee has leave request and saved absence ,then save employee attendance as absent profile
        elseif($absence != null){
	    $attendance['employee_id']= $employee_id;
		$attendance['day']=$day;
		$attendance['from']= $from;
		$attendance['to']= $to;
		$attendance['work_schedule_id']= $work_schedule_id;
		$attendance['overtime_profile_id']= $overtime_profile_id;
		$attendance->save();
         }				
		}
  }
  /******************************************************************************************************************************************/
 public static function restorDelayAndOvertime($attendance,$attendanceNet){
	 $employee = Employee::find($attendance->employee_id);
	 if($attendance->work_schedule_id == 1){
		$absence =  Absence::where('employee_id',$employee->id)->where('day',$attendance->day)->first();
			if($absence){
			$absence->delete();
			$leave = Leave::find($absence->leave_id);
		 if($leave != null){
			         $leave_id = $leave->id;
					 if($leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance - $employee->work_schedule->work_duration ;
					 }
					 elseif($leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde+ $employee->work_schedule->work_duration ;
					 }
		             $employee->save();	 
		 }
		 else{
			  $employee->solde =  $employee->solde+ $employee->work_schedule->work_duration ;
		 }
		    $employee->save();
			
			}
		}
		if($attendanceNet){
		$employee->delay_balance = $employee->delay_balance + $attendanceNet->deducted_delay  - $attendanceNet->delay ;
		$employee->overtime_hours = $employee->overtime_hours - $attendanceNet->overtime_net_percentage ;
		$employee->save();
		}
		
 }
   public static function recalculateMonthDelay($employee_id,$month){
	   date_default_timezone_set("Africa/Cairo");	
	   $employee = Employee::find($employee_id);
	   $Attendances = Attendance::where('employee_id',$employee_id)->where('work_schedule_id','!=',1)->whereMonth('day',$month)->orderBy('id','desc')->get();
		foreach ($Attendances as $attendance){
		self::store($attendance,$attendance->employee_id,$attendance->day,$attendance->from,$attendance->to,$attendance->work_schedule_id,$attendance->overtime_profile_id);
		
}

   }
}