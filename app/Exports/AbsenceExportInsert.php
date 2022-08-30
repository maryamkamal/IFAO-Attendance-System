<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Absence;
class AbsenceExportInsert implements WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
	 public function headings(): array
    {
		 return [
		'employee_code','day'
        ];
    }
}
