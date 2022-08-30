<?php

namespace App;

use App\Employee;
use Illuminate\Database\Eloquent\Model;
use App\Permission;

class EmployeePermission extends Model
{
	protected $table ="employee_permissions";

 public function permission()
  {
    return $this->belongsTo(Permission::class, 'permission_id');
  }
  public function employee()
  {
    return $this->belongsTo(Employee::class, 'employee_id');
  }
    public function approved_by()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }
}
