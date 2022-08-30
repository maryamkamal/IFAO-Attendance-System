<?php

namespace App\Exports;
use App\EmployeePermission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeePermissionExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;


    public function collection()
    {
       $EmployeeLeaves = EmployeePermission::select( 'employee_id','permission_id','day','from','to','status')->orderBy('id')->get();
        return $EmployeeLeaves;
    }
	 public function headings(): array
    {
        return [
		    'employee_id','permission_id','day','from','to','status'
        ];
    }
}