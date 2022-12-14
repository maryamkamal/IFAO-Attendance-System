<?php

namespace App\Imports;

use Exception;
use App\WorkScheduleProfile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use DB;
class WorkScheduleProfileImport implements ToCollection, WithHeadingRow
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
               '*.work_days' => 'required',
              /* '*.start' => 'date_format:H:i:s',
                '*.end' => 'date_format:H:i:s',
                 '*.work_duration' => 'numeric',*/
          ])->validate();


        foreach ($rows as $row) {
            DB::table('work_schedule_profiles')->insert([
                'name' => $row["name"],
                'work_days' => serialize(explode(",", $row["work_days"])),
                'start' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["start"])->format('H:i:s'),
                'end' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["end"])->format('H:i:s'),
                'work_duration' => $row["work_duration"],
                'created_at' => date('Y-m-d H:i:s'),

            ]);

        }

    }
}                                                                                                                                                                                                
