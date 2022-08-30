<?php

namespace App\Http\Controllers;
use App\Leave;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeaveExport;
use App\Exports\LeaveInsert;
use App\Imports\LeaveImport;
use DataTables;
use Log;
class LeaveController extends Controller
{
	public function index(Request $request){
	$leaves = Leave::all();
         if ($request->ajax()) {
     return Datatables::of($leaves)
     ->addIndexColumn()
	 ->addColumn('check_all', function($leave){

   $check_all = ' <input type="checkbox" class="checkbox" name="leaves_ids[]" value="'.$leave->id.'"> ';

   return $check_all;
})
   ->addColumn('action', function($leave){
if(auth()->user()->authority('modify','leave_types')==1){
   $btn = ' <span class="edit-btn">
            <a href="leaves/edit/'.$leave->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="leaves/delete/'.$leave->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
}
})
->addColumn('is_paid', function($leave){
if($leave->is_paid ==1){
   return "Yes";
}
else{
	 return "No";
}
})
->addColumn('solde_deduction', function($leave){
if($leave->solde_deduction ==1){
   return "Yes";
}
else{
	 return "No";
}
})

->rawColumns(['action','is_paid','check_all','solde_deduction'])
->make(true);
}
      	return view('leaves.index');
	}
  /*** show create Leave page with vacations list table ***/
	public function create(Request $request){
		 return view('leaves.create');
	}
	
	/****store Leave data***/
	public function store(Request $request){
		$Leave = new Leave;
		$Leave['type']= $request->type;
		$Leave['is_paid']= $request->is_paid;
		$Leave['solde_deduction']= $request->solde_deduction;
		$Leave->save();
		Log::info("New Leave Added By ".auth()->user()->employee->full_name_en);
		return redirect("leaves/index")->with('success', 'leave is successfully added');
	}
	 /*** show edit Leave page ***/
	public function edit($id)
   {
	 $leave= Leave::find($id);
     return view('leaves.edit',compact('leave'));
   }
   /************** update Leave record in db  *****************/
	 public function update($id, Request $request)
   {
	   /**intializing user record that wanted to be updated ***/
        $Leave= Leave::find($id);
		Log::info( $Leave->type." Leave Updated By ".auth()->user()->employee->full_name_en);
	    $Leave['type']= $request->type;
		$Leave['is_paid']= $request->is_paid;
		$Leave['solde_deduction']= $request->solde_deduction;
		$Leave->save();
      return redirect("leaves/index")->with('success', 'leave is successfully updated');
}
    /************** delet Leave *****************/
   public function delete($id)                      
    {
        $Leave = Leave::findOrFail($id);
		Log::info( $Leave->type." Leave Deleted By ".auth()->user()->employee->full_name_en);
        $Leave->delete();
		
        return back()->with('success', 'leave is successfully deleted');
    }
	 public function deleteSelected(Request $request)
	{
      $leaves_ids = $request->get('leaves_ids');
        foreach( $leaves_ids as  $id){
			$this->delete($id);	
		}
      return back()->with('success','leaves is successfully deleted');
    }
	public function export()  
   {
	   return Excel::download(new LeaveExport , 'leaves_import.xlsx');
	   Log::info(" Leaves Excel Sheet Exported By ".auth()->user()->employee->full_name_en);
	   return back()->with('success', 'Leaves Are Exported successfully');
   }
   /*******  export users excel sheet with heading to insert ***********/
	 public function export_insert() 
   {
	   return Excel::download(new LeaveInsert , 'Leave_Heading.xlsx');
	   Log::info(" Leaves Inserting Excel Sheet Exported By ".auth()->user()->employee->full_name_en);
	  return back()->with('success', 'Leaves Are Exported successfully');
   }
    /*******  import users excel sheet ***********/
	 public function import(Request $request)   
    {
	
        $this->validate($request, [
      'leave_import'  => 'required|mimes:xls,xlsx'
     ]);
	    
     Excel::import(new LeaveImport, request()->file('leave_import'));
	 Log::info(" Leaves  Excel Sheet Imported By ".auth()->user()->employee->full_name_en);
     return back()->with('success', 'Excel Data Imported successfully.');
	
	}
}