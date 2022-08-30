<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OverTimeProfile;
use App\WorkScheduleProfile;
class Employee extends Model
{
    protected $fillable = [
        'full_name_ar', 'full_name_en','code','email','address','job_title','salary','phone','overtime','working_type'
    ];

	 public function overtime_profile()
  {
    return $this->belongsTo(OverTimeProfile::class,'work_overtime_profile_id');
  }
   public function work_schedule()
  {
    return $this->belongsTo(WorkScheduleProfile::class,'work_schedule_profile_id');
  }
}
