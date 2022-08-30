<?php

namespace App\Http\Controllers\Reports;
use App\Employee;
use App\SavedReport;
use App\Permission;
use App\Leave;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use PDF ;
use App\WorkScheduleProfile;
use App\OvertimeProfile;
use doctrine\dbal;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;
class GenerateReportController extends Controller
{

    public function generate()
    {
        return view('reports.generate');
    }

    public function getTableColumns(Request $request)
    {
        $columns = [];
        $filters = '';
        if ($request->table_name) {
            session(['select_columns'=>null]);
            session(['table_name' => $request->table_name]);
            $table_columns = Schema::getColumnListing($request->table_name);
            foreach ($table_columns as $table_column) {
                $columns[] = ' <div class="row  px-4 pt-0" id="coulmns_names">
                            <div class="form-group col-lg-6">
                        <input type="checkbox" class="form-check-input" name="table_columns[]" id="presence" value="' . $table_column . '" onClick="checked1(this)">
                                <label class="form-check-label" for="presence">' . $table_column . '</label>
                    </div>
                </div>';
            }
            $filters = ' <option >Select Column <option>';
            foreach ($table_columns as $table_column) {
                $filters .= ' <option value="' . $table_column . '">' . $table_column . '</option>';
            }

        }
        return response()->json(['columns' => $columns, 'filters' => $filters]);

    }

    public function getFilterInput(Request $request)
    {
        $employees = Employee::all();
        $permissions = Permission::all();
        $leaves = leave::all();
        $work_profiles = WorkScheduleProfile::all();
        $overtime_profiles = OvertimeProfile::all();
        if ($request->column_name) {
            $column_type = DB::getSchemaBuilder()->getColumnType(session('table_name'), $request->column_name);
            $input = '<input type="' . $column_type . '" class="form-control" name="filter_value[]">';
            if ($request->column_name == "employee_id" || session('table_name') == "employees" && $request->column_name == "id") {

                $input = ' <select class="form-control" name="filter_value[]">
                              <option value="all_employees">All Employees </option>';
                foreach ($employees as $employee) {
                    $input .= '<option value="' . $employee->id . '">' . $employee->full_name_en . '</option>';
                }
                $input .= '</select> ';

            } elseif ($request->column_name == "approved_by") {
                $input = '<select class="form-control" name="filter_value">';
                foreach ($employees as $employee) {
                    $input .= '<option value="' . $employee->id . '">' . $employee->full_name_en . '</option>';
                }
                $input .= '</select>';

            } elseif ($request->column_name == "permission_id" || session('table_name') == "permissions" && $request->column_name == "id") {
                $input = '  <select class="form-control" name="filter_value[]" >';
                foreach ($permissions as $permission) {
                    $input .= '<option value="' . $permission->id . '">' . $permission->type . '</option>';
                }
                $input .= '</select>';

            } elseif ($request->column_name == "leave_id" || session('table_name') == "leaves" && $request->column_name == "id") {
                $input = ' <select class="form-control" name="filter_value[]">';
                foreach ($leaves as $leave) {
                    $input .= '<option value="' . $leave->id . '">' . $leave->type . '</option>';
                }
                $input .= '</select>';
            } elseif ($request->column_name == "work_schedule_id" || session('table_name') == "work_schedule_profiles" && $request->column_name == "id") {
                $input = ' <select class="form-control" name="filter_value[]">';
                foreach ($work_profiles as $work_profile) {
                    $input .= '<option value="' . $work_profile->id . '">' . $work_profile->name . '</option>';
                }
                $input .= '</select>';
            } elseif ($request->column_name == "overtime_profile_id" || session('table_name') == "over_time_profiles " && $request->column_name == "id") {
                $input = ' <select class="form-control" name="filter_value[]">';
                foreach ($overtime_profiles as $overtime_profile) {
                    $input .= '<option value="' . $overtime_profile->id . '">' . $overtime_profile->name . '</option>';
                }
                $input .= '</select>';
            }

        }
        return response()->json(['input' => $input]);
    }

    public function runQuery (Request $request)
    {
        
        $tableModel = session('table_name');
        $selected_columns = $request->table_columns;
		/******** start query selection **/
        $query = DB::table($tableModel);
		if($selected_columns != null){
        $query->select($selected_columns);
		}
		
		/******************************/
       
			/******** start query filters **/
		 $filters = $request->filters;
		
		if($filters[0]['filter_operator'] != null){
		$count_filter_values = count($request->filter_value);
		$filter_values = $request->filter_value ;
		$counter = 0;
        foreach($filters as $filter) {
			if($counter < $count_filter_values){
	          if($filter['filter_operator'] =='like'){
              $query->where($filter['filter_column'], $filter['filter_operator'], '%'.$filter_values[$counter].'%');
	         }
			 elseif($filter_values[$counter] != 'all_employees'){
				 $query->where($filter['filter_column'], $filter['filter_operator'], $filter_values[$counter]);
			 }  
        }
		$counter++ ;
		}
			}
		 $query_results = $query->get();
         session(['selected_columns'=>$selected_columns,'query_results'=>$query_results,'report_name'=>$request->report_name,'filters'=>$filters,'filter_values'=>$filter_values]);
		 
       return view('reports.generated-result',compact('query_results','selected_columns','tableModel'));

    }
	public function export()
   {
	   return Excel::download(new ReportExport ,session('table_name').'.xlsx');
	   return back()->with('success', session('table_name').'is exported successfully');
   }
    public function print_pdf(){
		$tableModel = session('table_name');
        $selected_columns = session('selected_columns');
		$query_results = session('query_results');
      $pdf = PDF::loadView('reports.pdf', compact('query_results','selected_columns','tableModel'));
      return $pdf->download('report.pdf');
}
// save generated report variables
   public function save(Request $request)
   {
	   $new_report= new SavedReport ;
	   $new_report->report_name = session('report_name');
	   $new_report->table_name = session('table_name');
	   $new_report->selected_columns = serialize(session('selected_columns'));
	   $new_report->filters =serialize( session('filters'));
	   $new_report->filter_values =serialize( session('filter_values'));
	   $new_report->save();
	   return redirect('reports/generate')->with('success', session('report_name').' Saved Successfully');
   
   }
}
