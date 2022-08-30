<?php

namespace App\Imports;

use Exception;
use App\EmployeePermission;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use DB;
class PermissionImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
             '*.type' => 'required',
			  '*.is_paid' => 'required|numeric',


         ])->validate();


		foreach ($rows as $row)
		{
			DB::table('permissions')->insert([
			'type' =>$row["type"],
			'is_paid' =>$row["is_paid"],
                'created_at' => date('Y-m-d H:i:s'),



        ]);

		   }

         }
	}
