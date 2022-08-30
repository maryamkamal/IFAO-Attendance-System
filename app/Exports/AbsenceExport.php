<?php

namespace App\Exports;
use App\Absence;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsenceExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;


    public function  array(): array{
    
       $absences =Absence::select('employee_id','day')->orderBy('id')->get();
	   $count =count( $absences);
	   $counter =0;
	    $records = [] ;
		
	   foreach( $absences as  $absence){
		   if($counter < $count){
		   $records[$counter]['id'] = $absence->id;
		   $records[$counter]['full_name_en'] = $absence->employee->full_name_en;
		   $records[$counter]['code'] =$absence->employee->code;
		   $records[$counter]['day'] = date('Y-m-d', strtotime($absence->day));
		  
	   }
	   $counter ++;
	   }
        return $records;
    }
	 public function headings(): array
    {
        return [
		'id','full_name_en','employee_code','day'
        ];
    }
}



