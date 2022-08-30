<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkScheduleProfileInsert implements WithHeadings
{
   
    public function headings(): array
    {
        return [
		   'name','work_days','start','end','work_duration'
		   
        ];
    }
}


