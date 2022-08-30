<?php

namespace App\Imports;

use Exception;
use App\Employee;
use App\EmployeeInputField;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use DB;
class EmployeeImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
             '*.full_name_en' => 'required',
			 '*.code' => 'required',
			 '*.rfid_id' => 'required',
			  '*.overtime_profile_id' => 'required|numeric',
			 '*.work_schedule_id' => 'required|numeric',
			  '*.work_schedule_id' => 'required|numeric',
			  
         ])->validate();


		foreach ($rows as $row)
		{
			$employee_check = Employee::where('code',$row['code'])->first();
			if($employee_check != null){
				$employee= $employee_check;
			}
			else{
		    $employee= new Employee;
			}
		$input_fields = EmployeeInputField::select('name')->where('type', '!=' ,'file')->get();
		
		if($input_fields!= null){
			 $name="";
		foreach($input_fields as $input_field) {
			//dd($row[$input_field->name]);
            $name = $input_field->name;
            $employee[$name] = $row[$name];
        }
		}
		$current_salary_start =null;
	   if(!is_string($row["salary_start"])){
		if((bool)strtotime($row["salary_start"]) == false){
		$current_salary_start =\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["salary_start"])->format('Y-m-d');
		}
		else{
			$current_salary_start =$row["salary_start"];
		}
		}
		$employee['full_name_en']= $row['full_name_en'];
		$employee['code']= $row['code'];
		$employee['rfid_id']= $row['rfid_id'];
		$employee['work_overtime_profile_id']= $row['overtime_profile_id'];
		$employee['work_schedule_profile_id']= $row['work_schedule_id'];
		$employee['salary']= $row['salary'];
		$employee['salary_start']= $current_salary_start;
		$employee['hourly_labor_cost']= $row['salary']/(30*8);
		$employee['solde']= $row['solde'];
		$employee['delay_balance']= $row['delay_balance'];
		$employee['overtime_hours']= $row['overtime_hours'];
		$employee->save();
			
	}
	}
}




