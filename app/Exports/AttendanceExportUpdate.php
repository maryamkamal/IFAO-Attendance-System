<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Attendance;
class AttendanceExportUpdate implements FromArray, WithHeadings
{
    private $data;


    public function  array(): array{
    
	$employees = session('employee_id');
	$from = session('from');
	$to = session('to');
	if($employees != "all_employees"){
     $attendances = Attendance::select('id','employee_id','day','from','to','work_schedule_id','overtime_profile_id')
	        ->where('employee_id',$employees)
	        ->whereDate('day', '>=',$from)
            ->whereDate('day', '<=', $to)->orderBy('id')->get();
	}
	else{
		$attendances = Attendance::select('id','employee_id','day','from','to','work_schedule_id','overtime_profile_id')
	        ->whereDate('day', '>=',$from)
            ->whereDate('day', '<=', $to)->orderBy('id')->get();
	}
	   $count =count( $attendances);
	   $counter =0;
	    $records = [] ;
		
	   foreach( $attendances as  $attendance){
		   if($counter < $count){
		   $records[$counter]['id'] = $attendance->id;
		   $records[$counter]['full_name_en'] = $attendance->employee->full_name_en;
		   $records[$counter]['code'] =$attendance->employee->code;
		   $records[$counter]['day'] = date('Y-m-d', strtotime($attendance->day));
		   $records[$counter]['from'] =$attendance->from;
		   $records[$counter]['to'] = $attendance->to;
		   $records[$counter]['work_schedule_id'] = $attendance->work_schedule_id;
		   $records[$counter]['overtime_profile_id'] =$attendance->overtime_profile_id;
	   }
	   $counter ++;
	   }
        return $records;
    }
	 public function headings(): array
    {
        return [
		'id','full_name_en','employee_code','day','from','to','work_schedule_id','overtime_profile_id'
        ];
    }
}