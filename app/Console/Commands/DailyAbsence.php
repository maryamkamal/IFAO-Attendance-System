<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Employee;
use App\Absence;
use App\Attendance;
use App\vacation;
use App\WorkScheduleProfile;
use App\EmployeeLeave;
class DailyAbsence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absence:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'save absent employees ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    date_default_timezone_set("Africa/Cairo");
	$day = date("Y-m-d");
	 $today_name = date('l', strtotime($day));
	$vacation =vacation::whereDate('from', '<=', date("Y-m-d"))
                        ->whereDate('to', '>=', date("Y-m-d"))->first();
	$employees = Employee::all();
   foreach($employees as $employee){
	$absence =  Absence::where('employee_id',$employee->id)->where('day',$day)->first();
	$employee_schedule =WorkScheduleProfile::where('id',$employee->work_schedule->id)->first();
    $employee_schedule_days = unserialize($employee_schedule->work_days);
	$employee_attendance = Attendance::where('employee_id',$employee->id)->where('day',$day)->first();
	 //if there is no vacations or weekend store employee absence
		if($absence == null && $vacation == null && in_array($today_name,$employee_schedule_days) && $employee_attendance == null){
			//save attendance as absent profile
				
		        $EmployeeLeave=EmployeeLeave::where('employee_id',$employee->id)
				             ->whereDate('from', '<=',$day)
                             ->whereDate('to', '>=', $day)
							 ->where('status','approved')
							 ->first();
		             $leave_id =null;
					 $leave_status = null;
		  if($EmployeeLeave != null){
			         $leave_id = $EmployeeLeave->leave_id;
					  $leave_status = "approved";
					 if($EmployeeLeave->leave->is_paid != 1){
						 $employee->delay_balance = $employee->delay_balance + $employee_schedule->work_duration ;
					 }
					 elseif($EmployeeLeave->leave->solde_deduction == 1){
				     $employee->solde =  $employee->solde- $employee_schedule->work_duration ;
					 } 
		 }
		 else{
			 $employee->solde =  $employee->solde- $employee_schedule->work_duration ;
		 }
		 $absence= new Absence;
		$absence['employee_id']= $employee->id;
		$absence['day']=$day;
		$absence['leave_id']=$leave_id;
		$absence['leave_status']=$leave_status;
		$absence->save();
		$employee->save();
		
				}
   }
			 $this->info('Successfully add daily Absence.');
    
	}

}
