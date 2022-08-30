<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OvertimeProfileInsert implements WithHeadings
{
   
    public function headings(): array
    {
        return [
		   'name','first_two_hours_ratio','next_hours_ratio','weekend_days_ratio','holidays_ratio','is_paid','premium'
		   
        ];
    }
}


