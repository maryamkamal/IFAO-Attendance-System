<?php

namespace App\Imports;

use Exception;
use App\Vacation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use DB;
class VacationImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     public function collection(Collection $rows)
    {
        date_default_timezone_set("Africa/Cairo");
        Validator::make($rows->toArray(), [
             '*.name' => 'required',
            '*.from' => 'required',
            '*.to' => 'required',


         ])->validate();


		foreach ($rows as $row)
		{
		  //  $from= strtotime();
		 
			DB::table('vacations')->insert([
			'name' =>$row["name"],
			'from' =>$row["from"],
			'to' =>$row["to"],
                'created_at'=>date('Y-m-d H:i:s'),



        ]);

		   }

         }
	}
