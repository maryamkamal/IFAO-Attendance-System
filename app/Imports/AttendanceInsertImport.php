<?php

namespace App\Imports;

use Exception;
use App\Attendance;
use App\Absence;
use App\Employee;
use App\vacation;
use App\WorkScheduleProfile;
use App\OverTimeProfile;
use App\EmployeeLeave;
use App\AttendanceNet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Log;
class AttendanceInsertImport implements ToCollection, WithHeadingRow
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
        $count = 1;
		//insializing error messages session
		 $arr = [];
		Session::put('upload_error', $arr);
		foreach ($rows as $row){	
		$employee = Employee::where('code',$row["employee_code"])->first();
		$counter= ++$count ;
		$employee_id =$employee->id;
		if($row["work_schedule_id"]){
		$work_schedule_id = $row["work_schedule_id"];
		}else{
			$work_schedule_id = $employee->work_schedule_profile_id;
		}
		if($row["overtime_profile_id"]){
		$overtime_profile_id = $row["overtime_profile_id"];
		}else{
			$overtime_profile_id = $employee->work_overtime_profile_id;
		}
		
		if(!is_string($row["day"])){
		if((bool)strtotime($row["day"]) == false){
		$day =\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["day"])->format('Y-m-d');
		}
		else{
			$day =$row["day"];
		}
		}
		if(!is_string($row["from"])){
		if($row["from"] != null){
		     $from =\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["from"])->format('H:i:s');
			}
			else{
				$from = null ;
			}
		}
		 if(!is_string($row["to"])){
			if($row["to"] != null ){
		     $to =\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["to"])->format('H:i:s');
			}
			else{
				$to = null ;
			}
		}
			//absence case 
		if($row["from"] == null && $row["to"] == null && $row["work_schedule_id"] == null){
			
		$attendance = new Attendance;
		Log::info($employee->full_name_en." Attendance For Day (".$day.") added By  ".auth()->user()->employee->full_name_en);
		 Attendance::store( $attendance,$employee_id,$day,$from,$to,1,$overtime_profile_id);
		}
		elseif(is_string($row["from"]) || is_string($row["to"]) || is_string($row["day"])){
			
			Session::push('upload_error',"Row Number ".$counter ." Can't Be Inserted ,It Has Wrong Data !");
			Log::error("Importing Error ! , Row Number ".$counter ." Can't Be Inserted ,It Has Wrong Data ! , Added By User : ".auth()->user()->employee->full_name_en);
		}
		else{
		 $attendance = new Attendance;
		 Log::info($employee->full_name_en." Attendance For Day (".$day.") added By  ".auth()->user()->employee->full_name_en);
		 Attendance::store( $attendance,$employee_id,$day,$from,$to,$work_schedule_id,$overtime_profile_id);
		}
		$counter++;
		}
		
	}
}
