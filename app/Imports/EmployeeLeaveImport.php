<?php

namespace App\Imports;

use Exception;
use App\EmployeeLeave;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use DB;
class EmployeeLeaveImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
             '*.employee_id' => 'required|numeric',
			  '*.leave_id' => 'required|numeric',
			 '*.from' => 'required',
			  '*.to' => 'required',

         ])->validate();


		foreach ($rows as $row)
		{
			DB::table('employee_leaves')->insert([
			'employee_id' =>$row["employee_id"],
			'leave_id' =>$row["leave_id"],
			'from' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["from"])->format('Y-m-d'),
			'to' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["to"])->format('Y-m-d'),
		    'status' =>"pending",
                'created_at'=>date('Y-m-d H:i:s'),


        ]);

		   }

         }
	}
