<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\EmployeeInputField;
class EmployeeExportInsert implements WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
	 public function headings(): array
    {
		$input_fields = EmployeeInputField::select('name')->where('type', '!=' ,'file')->get();
		 $static_inputs = ['full_name_en','code','rfid_id','work_schedule_id','overtime_profile_id','salary','current_salary_start','solde','delay_balance','overtime_hours'];
		 $dynamic_inputs=[];
		 foreach($input_fields as $input_field){
			$dynamic_inputs[] = $input_field->name;
		 }
		$all_inputs= array_merge($static_inputs,$dynamic_inputs);
        return $all_inputs;
    }
}
