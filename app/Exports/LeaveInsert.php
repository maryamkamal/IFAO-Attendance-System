<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveInsert implements WithHeadings
{
   
    public function headings(): array
    {
        return [
		   'type','is_paid'
		   
        ];
    }
}


