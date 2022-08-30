<?php

namespace App\Exports;
use DB;
use App\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExportInsert implements WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
	 public function headings(): array
    {
        return [
		   'employee_id','leave_id','from','to'
        ];
    }
}
