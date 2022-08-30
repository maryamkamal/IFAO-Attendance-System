<?php

namespace App\Exports;
use App\WorkScheduleProfile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class  WorkScheduleProfileExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;


    public function collection()
    {
       $WorkScheduleProfile = WorkScheduleProfile::select( 'name','work_days','start','end','work_duration')->orderBy('id')->get();
        return $WorkScheduleProfile;
    }
	 public function headings(): array
    {
        return [
		  'name','work_days','start','end','work_duration'
        ];
    }
}