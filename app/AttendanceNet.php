<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceNet extends Model
{
	protected $table ="attendance_net";
    
	 public function employee()
  {
    return $this->belongsTo(Employee::class, 'employee_id');
  }
}
