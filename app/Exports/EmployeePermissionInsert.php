<?php

namespace App\Exports;
use DB;
use App\EmployeeLeave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeePermissionInsert implements WithHeadings
{
   
    public function headings(): array
    {
        return [
		   'employee_id','permission_id','day','from','to'
		   
        ];
    }
}


