<?php

namespace App\Exports;
use App\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PermissionExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;


    public function collection()
    {
       $Permission = Permission::select('type','is_paid')->orderBy('id')->get();
        return $Permission;
    }
	 public function headings(): array
    {
        return [
		  'type','is_paid'
        ];
    }
}