<?php

namespace App\Exports;
use DB;
use App\EmployeeLeave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PermissionInsert implements WithHeadings
{
   
    public function headings(): array
    {
        return [
		   'type','is_paid'
		   
        ];
    }
}


