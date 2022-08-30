<?php

namespace App\Exports;
use App\AttendanceNet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceNetExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;


    public function  array(): array{
    
       $attendances = AttendanceNet::select('employee_id','day','worked_duration','overtime_hours','overtime_net_percentage','delay')->orderBy('id')->get();
	   $count =count( $attendances);
	   $counter =0;
	    $records = [] ;
		
	   foreach( $attendances as  $attendance){
		   if($counter < $count){
		   $records[$counter]['full_name_en'] = $attendance->employee->full_name_en;
		   $records[$counter]['day'] = date('Y-m-d', strtotime($attendance->day));
		   $records[$counter]['worked_duration'] = $attendance->worked_duration;
		   $records[$counter]['overtime_hours'] = $attendance->overtime_hours;
		    $records[$counter]['overtime_bonus'] = $attendance->overtime_bonus;
		   $records[$counter]['overtime_net_percentage'] =  $attendance->overtime_net_percentage;
		   $records[$counter]['delay'] =  $attendance->delay;
	   }
	   $counter ++;
	   }
        return $records;
    }
	 public function headings(): array
    {
        return [
		'full_name_en','day','worked_duration','overtime_hours','overtime_bonus','overtime_net_percentage','delay'
        ];
    }
}