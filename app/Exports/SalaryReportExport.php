<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalaryReportExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;


    public function array(): array{
    
		 $count =count(session('employees'));
		$employee_overtime_bonus = session('employee_overtime_bonus');
	   $counter =0;
	    $records = [] ;
		foreach( session('employees') as $employee){
			if($counter < $count){
				
				  if($employee->solde <= 0){
					  $employee_total_salary =  $employee->salary -($employee->hourly_labor_cost * $employee->delay_balance);	 
				 }
				 else {
					  $employee_total_salary =  $employee->salary + $employee_overtime_bonus[$employee->id];
					  $is_paid = "No";
				 }
		   $records[$counter]['full_name_en'] = $employee->full_name_en;
		   $records[$counter]['salary'] = $employee->salary;
		   $records[$counter]['hourly_labor_cost'] =$employee->hourly_labor_cost;
		   $records[$counter]['delay_balance'] = $employee->delay_balance;
		   $records[$counter]['vacations_balance'] = round($employee->solde /8,2);
		   $records[$counter]['overtime_bonus'] = $employee_overtime_bonus[$employee->id];
		   $records[$counter]['employee_total_salary'] =$employee_total_salary;
	   }
	   $counter ++;
	   }
        return $records;
		}
      
	 public function headings(): array
    {
        return ['Employee','Salary','Hourly Labor Cost','Cumulative Delay','Vacations Balance','Cumulative Overtime Bonus','Total Salary'];
    }
}