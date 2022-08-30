<?php

namespace App\Http\Controllers;
use App\Vacation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VacationExport;
use App\Exports\VacationInsert;
use App\Imports\VacationImport;
use DataTables;
use Log;
class VacationController extends Controller
{
	public function index(Request $request){
	 $vacations = Vacation::all();
         if ($request->ajax()) {
     return Datatables::of($vacations)
     ->addIndexColumn()
	 ->addColumn('check_all', function($vacation){

   $check_all = ' <input type="checkbox" class="checkbox" name="vacations_ids[]" value="'.$vacation->id.'"> ';

   return $check_all;
})
   ->addColumn('action', function($vacation){
if(auth()->user()->authority('modify','official_holidays')==1){
   $btn = ' <span class="edit-btn">
            <a href="vacations/edit/'.$vacation->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="vacations/delete/'.$vacation->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
}
})

->rawColumns(['action','check_all'])
->make(true);
}
	 return view('vacations.index',['vacations'=>$vacations]);
	}

  /*** show create vacation page  ***/
	public function create(Request $request){
		 return view('vacations.create');
	}

	/****store vacation data***/
	public function store(Request $request){
		$vacation = new Vacation;
		$vacation['name']= $request->name;
		$vacation['from']= $request->from;
        $vacation['to']= $request->to;
		$vacation['holiday_type']= $request->holiday_type;
		$vacation->save();
		return redirect("vacations/index")->with('success', 'Vacation is successfully added');
	}
	 /*** show edit vacation page ***/
	public function edit($id)
   {
	 $vacation= Vacation::find($id);
     return view('vacations.edit',compact('vacation'));
   }
   /************** update vacation record in db  *****************/
	 public function update($id, Request $request)
   {
	   /**intializing user record that wanted to be updated ***/
        $vacation= Vacation::find($id);
	    $vacation['name']= $request->name;
       $vacation['from']= $request->from;
       $vacation['to']= $request->to;
	   $vacation['holiday_type']= $request->holiday_type;
	   $vacation->save();
      return redirect("vacations/index")->with('success', 'Vacation is successfully updated');
}
    /************** delet vacation *****************/
   public function delete($id)
    {
        $vacation = Vacation::findOrFail($id);
        $vacation->delete();

        return back()->with('success', 'Vacation is successfully deleted');
    }
	 public function deleteSelected(Request $request)
	{
      $vacations_ids = $request->get('vacations_ids');
        Vacation::destroy($vacations_ids);
      return redirect("vacations/index")->with('success', 'Selected Vacations Are Successfully Deleted');
    }
public function export()
   {
	   return Excel::download(new VacationExport , 'Vacation_import.xlsx');
	   return back()->with('success', 'Vacations are exported successfully');
   }
   /*******  export users excel sheet with heading to insert ***********/
	 public function export_insert()
   {
	   return Excel::download(new VacationInsert , 'Holidays_Heading.xlsx');
	   return back();
   }
    /*******  import users excel sheet ***********/
	 public function import(Request $request)
    {

        $this->validate($request, [
      'vacation_import'  => 'required|mimes:xls,xlsx'
     ]);

     Excel::import(new VacationImport, request()->file('vacation_import'));

     return back()->with('success', 'Excel Data Imported successful');
	}
}
