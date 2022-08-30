<?php

namespace App\Exports;
use App\ EmployeeLeave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeLeaveExport implements FromCollection, WithHeadings
{


    public function collection()
    {
       $EmployeeLeaves = EmployeeLeave::select('employee_id','leave_id','from','to','status')->orderBy('id')->get();
        return $EmployeeLeaves;
    }
	 public function headings(): array
    {
        return [
		    'employee_id','leave_id','from','to','status'
        ];
    }
}
