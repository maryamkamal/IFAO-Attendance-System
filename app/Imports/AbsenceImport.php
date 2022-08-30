<?php

namespace App\Imports;

use Exception;
use App\Absence;
use App\Employee;
use App\EmployeeLeave;
use App\vacation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use DB;
class AbsenceImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     public function collection(Collection $rows)
    {
        date_default_timezone_set("Africa/Cairo");
        Validator::make($rows->toArray(), [
             '*.employee_code' => 'required',
	      	 '*.day' => 'required',

         ])->validate();


		foreach ($rows as $row)
		{
			if((bool)strtotime($row["day"]) == false){
		     $day =\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["day"])->format('Y-m-d');
		   }
		   else{
			$day =$row["day"];
		  }
		$employee = Employee::where('code',$row["employee_code"])->first();
		$employee_schedule =WorkScheduleProfile::where('id', $employee->work_schedule->id)->first();
		   $day_name = date('l', strtotime($day));
		   $employee_schedule_days = unserialize($employee->work_schedule->work_days);
		   $vacation = vacation::whereDate('from', '<=',$day)
                             ->whereDate('to', '>=', $day)->first();
	 if(($vacation == null || ( $vacation->holiday_type != 0 && $vacation->holiday_type !=  $employee->holiday_type )) && in_array($day_name,$employee_schedule_days)){
		$EmployeeLeave=EmployeeLeave::where('employee_id',$employee->id)
				             ->whereDate('from', '<=',$day)
                             ->whereDate('to', '>=', $day)
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
		$absence['employee_id']= $employee->id;
		$absence['day'] = $day;
		$absence['leave_id']=$leave_id;
		$absence->save();
		$employee->save();
		  Log::info(Employee::find($employee->id)->full_name_en." Absence For Day (".$day.") Added By  ".auth()->user()->employee->full_name_en);
		$attendanceNet_of_day = AttendanceNet::where('employee_id',$employee->id)->where('day',$day)->first();
		if( $attendanceNet_of_day != null){
			$attendanceNet_of_day->delete();
		}
				}

         }
	}
	}
	
	
