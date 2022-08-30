<?php

namespace App\Exports;
use DB;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
	$users=User::select('name','email')->orderBy('id')->get();
        return $users;
    }
	 public function headings(): array
    {
        return [
		    
            'name',
			'email' ,
        ];
    }
}
