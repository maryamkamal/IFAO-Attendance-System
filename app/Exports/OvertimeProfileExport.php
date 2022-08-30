<?php

namespace App\Exports;
use App\OvertimeProfile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class  OvertimeProfileExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;


    public function collection()
    {
       $OvertimeProfile = OvertimeProfile::select( 'name','first_two_hours_ratio','next_hours_ratio','weekend_days_ratio','holidays_ratio','is_paid','premium')->orderBy('id')->get();
        return $OvertimeProfile;
    }
	 public function headings(): array
    {
        return [
		 'name','first_two_hours_ratio','next_hours_ratio','weekend_days_ratio','holidays_ratio','is_paid','premium'
        ];
    }
}