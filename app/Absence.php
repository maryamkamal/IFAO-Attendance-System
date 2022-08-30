<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Employee;
use App\Employeeleave;
use App\leave;
class Absence extends Model
{

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    
	
}
