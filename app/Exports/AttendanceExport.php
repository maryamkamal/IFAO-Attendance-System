<?php

namespace App\Exports;
use App\Attendance;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;


    public function  array(): array{
    
       $attendances = Attendance::select('id','employee_id','day','from','to','work_schedule_id','overtime_profile_id')->orderBy('id')->get();
	   $count =count( $attendances);
	   $counter =0;
	    $records = [] ;
		
	   foreach( $attendances as  $attendance){
		   if($counter < $count){
		   $records[$counter]['full_name_en'] = $attendance->employee->full_name_en;
		   $records[$counter]['code'] =$attendance->employee->code;
		   $records[$counter]['day'] = date('Y-m-d', strtotime($attendance->day));
		   $records[$counter]['from'] = date('H:i:s', strtotime($attendance->from));
		   $records[$counter]['to'] = date('H:i:s', strtotime($attendance->to));
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
		'full_name_en','employee_code','day','from','to','work_schedule_id','overtime_profile_id'
        ];
    }
}