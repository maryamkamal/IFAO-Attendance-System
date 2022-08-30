<?php

namespace App\Exports;
use DB;
use App\EmployeeLeave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeLeaveInsert implements WithHeadings
{
   
    public function headings(): array
    {
        return [
		   'employee_id','leave_id','from','to'
		   
        ];
    }
}


