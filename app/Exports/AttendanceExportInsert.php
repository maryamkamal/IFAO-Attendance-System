<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Attendance;
class AttendanceExportInsert implements WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
	 public function headings(): array
    {
		 return [
		'full_name_en','employee_code','day','from','to','work_schedule_id','overtime_profile_id'
        ];
    }
}
