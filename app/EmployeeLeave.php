<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Leave;
use App\Employee;
class EmployeeLeave extends Model
{
	protected $table ="employee_leaves";
    
 public function leave()
  {
    return $this->belongsTo(Leave::class, 'leave_id');
  }
  public function employee()
  {
    return $this->belongsTo(Employee::class, 'employee_id');
  }
}
