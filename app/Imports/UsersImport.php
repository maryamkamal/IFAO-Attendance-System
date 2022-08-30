<?php

namespace App\Imports;
use DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class UsersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {


		foreach ($rows as $row)
		{
			DB::table('users')->insert([
			'name' =>$row["name"],
			'email' =>$row["email"],
            'password' => Hash::make($row["role_id"]),
			'role_id' =>$row["role_id"],

        ]);

		   }

         }
	}



