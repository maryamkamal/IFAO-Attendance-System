<?php

namespace App\Exports;
use App\Leave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;


    public function collection()
    {
       $Leave = Leave::select('type','is_paid')->orderBy('id')->get();
        return $Leave;
    }
	 public function headings(): array
    {
        return [
		  'type','is_paid'
        ];
    }
}