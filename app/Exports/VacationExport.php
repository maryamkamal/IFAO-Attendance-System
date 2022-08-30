<?php

namespace App\Exports;
use App\Vacation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VacationExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;


    public function collection()
    {
       $Vacation = Vacation::select('name','from','to')->orderBy('id')->get();
        return $Vacation;
    }
	 public function headings(): array
    {
        return [
		  'name','from','to'
        ];
    }
}