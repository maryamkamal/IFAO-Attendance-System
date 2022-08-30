<?php

namespace App\Imports;

use Exception;
use App\OvertimeProfile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use DB;
class OvertimeProfileImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
             '*.name' => 'required',
			 /* '*.first_two_hours_ratio' => 'float',
			  '*.next_hours_ratio' => 'float',
			   '*.weekend_days_ratio' => 'float',
			   '*.holidays_ratio' => 'float',
				'*.is_paid' => 'numeric',
				'*.premium' => 'numeric',
*/

         ])->validate();


		foreach ($rows as $row)
		{
			DB::table('over_time_profiles')->insert([
			'name' =>$row["name"],
			'first_two_hours_ratio'=>$row["first_two_hours_ratio"],
			'next_hours_ratio' =>$row["next_hours_ratio"],
			'weekend_days_ratio' =>$row["weekend_days_ratio"],
			'holidays_ratio' =>$row["holidays_ratio"],
			'is_paid' =>$row["is_paid"],
			'premium' =>$row["premium"],
                'created_at'=>date('Y-m-d H:i:s'),


        ]);

		   }

         }
	}
