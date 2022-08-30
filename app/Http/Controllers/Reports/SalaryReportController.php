<?php

namespace App\Http\Controllers\Reports;
use App\Employee;
use App\AttendanceNet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use PDF ;
use App\WorkScheduleProfile;
use App\OvertimeProfile;
use App\EmployeeSalaryHistory;
use doctrine\dbal;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalaryReportExport;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;
class SalaryReportController extends Controller
{

    public function index()
    {
      $employees= Employee::orderBy('full_name_en','asc')->get();
        return view('reports.salary',compact('employees'));
    }

    public function getSalaryReport(Request $request)
    {
		if($request->search_date){
			//dd(cal_days_in_month(CAL_GREGORIAN, 8, 2022));
			if($request->employee_id == "all"){
				 $employees= Employee::all();
	             $employee_overtime_bonus= [];
		         $salary_result= [];
				 foreach($employees as $employee){
					 $month = date('m',strtotime($attendance->day));
				 if($employee->salary_start =< $request->search_date){
					$employee_salary = $employee->salary;
				 }
				  if($employee->salary_start > $request->search_date){
					$employee_salary = $employee->salary;
				 }
			     $EmplyeeAttendanceNet =  AttendanceNet::select('overtime_bonus')->whereMonth('day',$request->month)->where('employee_id',$employee->id)->get();
				 $employee_overtime_bonus[$employee->id] =$EmplyeeAttendanceNet->sum('overtime_bonus') ; 
				 }
				 //set session variables to use in export excel 
				 session(['employees'=>$employees ,'employee_overtime_bonus'=>$employee_overtime_bonus ]);
				 
				  foreach($employees as $employee){
				 
				 if($employee->solde <= 0){
					  $employee_total_salary =  $employee->salary +($employee->hourly_labor_cost * $employee->solde);	 
				 }
				 else {
					 $employee_total_salary =  $employee->salary +$employee_overtime_bonus[$employee->id];
				 }
					  $salary_result[] = ' <tr>
											
											 <td>
											 '.$employee->full_name_en.'
											</td>
											<td>
											 '.$employee->salary.'
											</td>
											<td>
											 '.$employee->hourly_labor_cost .'
											</td>
											<td>
											 '.$employee->delay_balance  .'
											</td>
											<td>
											 '.round($employee->solde /8,2) .'
											</td>
											<td>
											'. $employee_overtime_bonus[$employee->id].'
											</td>
											<td>
											'. $employee_total_salary .'
											</td>
											
											</tr>';
					  
				  }
			}
			
			else {
				 $employee= Employee::find($request->employee_id);
				 $EmplyeeAttendanceNet =  AttendanceNet::select('overtime_bonus')->whereMonth('day',$request->month)->where('employee_id',$request->employee_id)->get();
				 $employee_overtime_bonus[$employee->id] = $EmplyeeAttendanceNet->sum('overtime_bonus') ; 
				  //set session variables to use in export excel 
				  session(['employees'=>$employee ,'employee_overtime_bonus'=>$employee_overtime_bonus ]);
				 
				 if($employee->solde < 0){
					  $employee_total_salary =  $employee->salary +($employee->hourly_labor_cost * $employee->solde);
					 
				 }
				 else {
					 $employee_total_salary =  $employee->salary + $employee_overtime_bonus[$employee->id];
					 
				 }
				 $salary_result = ' <tr>
											
											 <td>
											 '.$employee->full_name_en.'
											</td>
											<td>
											 '.$employee->salary.'
											</td>
											<td>
											 '.$employee->hourly_labor_cost .'
											</td>
											<td>
											 '.$employee->delay_balance  .'
											</td>
											<td>
											 '.round($employee->solde /8,2) .'
											 </td>
											<td>
											 '.$employee_overtime_bonus[$employee->id].'
											</td>
											
											<td>
											'.$employee_total_salary.'
											</td>
											
											</tr>';
			}
     
          
           return response()->json(['salary' => $salary_result]); 
        }
		else{
        return response()->json(['salary' => "No Result Found"]);
		}
    }

	public function export()
   {
	   return Excel::download(new SalaryReportExport ,'salary_report.xlsx');
	   return back()->with('success','Salary Report is exported successfully');
   }
    public function print_pdf(){
		$employees = session('employees');
        $employee_overtime_bonus = session('employee_overtime_bonus');
      $pdf = PDF::loadView('reports.salary_print', compact('employees','employee_overtime_bonus'));
      return $pdf->download('salary_print.pdf');
}
}
