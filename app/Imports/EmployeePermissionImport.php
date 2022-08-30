<?php

namespace App\Imports;

use Exception;
use App\EmployeePermission;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use DB;
class EmployeePermissionImport implements ToCollection, WithHeadingRow
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
			  '*.permission_id' => 'required|numeric',
			   '*.day' => 'required',
			 '*.from' => 'required',
			  '*.to' => 'required',

         ])->validate();


		foreach ($rows as $row)
		{
			DB::table('employee_permissions')->insert([
			'employee_id' =>$row["employee_id"],
			'permission_id' =>$row["permission_id"],
			'day' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["day"])->format('Y-m-d'),
			'from' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["from"])->format('H:i:s'),
			'to' =>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["to"])->format('H:i:s'),
		    'status' =>"pending",
                'created_at'=>date('Y-m-d H:i:s'),


        ]);

		   }

         }
	}
