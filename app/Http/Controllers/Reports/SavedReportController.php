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
class SavedReportController extends Controller
{

    public function index()
    {
		$savedReports= SavedReport::all();
        return view('reports.saved-reports',compact('savedReports'));
    }


    public function runQuery (Request $request)
    {
        $report= SavedReport::find($request->report_id);
        $tableModel = $report->table_name;
        $selected_columns =  unserialize($report->selected_columns);
		/******** start query selection **/
        $query = DB::table($tableModel);
		if($selected_columns != null){
        $query->select($selected_columns);
		}
		
		/******************************/
       
			/******** start query filters **/
		 $filters = unserialize($report->filters);
		if($filters[0]['filter_operator'] != null){
		$count_filter_values = count(unserialize($report->filter_values));
		$filter_values =unserialize($report->filter_values) ;
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
         session(['selected_columns'=>$selected_columns,'query_results'=>$query_results]);
       return view('reports.saved-result',compact('report','query_results','selected_columns','tableModel'));

    }
	public function export()
   {
	   return Excel::download(new ReportExport ,session('table_name').'.xlsx');
	   return redirect('reports/generate')->with('success', session('table_name').'is exported successfully');
   }
    public function print_pdf(){
		$tableModel = session('table_name');
        $selected_columns = session('selected_columns');
		$query_results = session('query_results');
      $pdf = PDF::loadView('reports.pdf', compact('query_results','selected_columns','tableModel'));
      return $pdf->download('report.pdf');
}
public function delete($id)
   {
	  $report= SavedReport::find($id);
	  $report->delete();
	   return redirect('reports/saved')->with('success', $report->report_name.' Deleted successfully');
   }
}
