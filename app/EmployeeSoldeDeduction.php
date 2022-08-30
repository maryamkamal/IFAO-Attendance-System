<?php

namespace App;

use App\Employee;
use Illuminate\Database\Eloquent\Model;


class EmployeeSoldeDeduction extends Model
{
	protected $table ="employee_solde_deductions";

  public function employee()
  {
    return $this->belongsTo(Employee::class, 'employee_id');
  }
    public function deducted_by()
    {
        return $this->belongsTo(Employee::class, 'deducted_by');
    }
}
