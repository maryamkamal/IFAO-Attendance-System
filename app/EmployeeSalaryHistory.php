<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryHistory extends Model
{
	protected $table ="employee_salary_histories";
    public function employee()
  {
    return $this->belongsTo(Employee::class, 'employee_id');
  }
}
