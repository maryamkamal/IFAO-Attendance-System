<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VacationInsert implements WithHeadings
{
   
    public function headings(): array
    {
        return [
		   'name','from','to'
		   
        ];
    }
}


