<?php

namespace App\Http\Controllers;
use App\OvertimeProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OvertimeProfileExport;
use App\Exports\OvertimeProfileInsert;
use App\Imports\OvertimeProfileImport;
use DataTables;
use Log;
class OvertimeProfileController extends Controller
{
	
	public function index(Request $request){
	$overtimes = OvertimeProfile::all();
         if ($request->ajax()) {
     return Datatables::of($overtimes)
     ->addIndexColumn()
	 ->addColumn('check_all', function($overtime){

   $check_all = ' <input type="checkbox" class="checkbox" name="overtime_profiles_ids[]" value="'.$overtime->id.'"> ';

   return $check_all;
})
   ->addColumn('action', function($overtime){
   if(auth()->user()->authority('modify','overtime_profiles')==1){
   $btn = ' <span class="edit-btn">
            <a href="overtime/profiles/edit/'.$overtime->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="overtime/profiles/delete/'.$overtime->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';
   return $btn;
   }
})

->rawColumns(['action','check_all'])
->make(true);
}
      	return view('overtime-profile.index');
	}
	public function create(){
	
	return view('overtime-profile.create');
	}
	public function store(Request $request){
		$overtime_profile = new OvertimeProfile;
		$overtime_profile->name= $request->name;
		$overtime_profile->first_two_hours_time_ratio= $request->first_two_hours_time_ratio;
		$overtime_profile->next_hours_time_ratio = $request->next_hours_time_ratio;
		$overtime_profile->weekend_days_time_ratio= $request->weekend_days_time_ratio;
		$overtime_profile->holidays_time_ratio =$request->holidays_time_ratio;
		$overtime_profile->first_two_hours_bonus_ratio= $request->first_two_hours_bonus_ratio;
		$overtime_profile->next_hours_bonus_ratio = $request->next_hours_bonus_ratio;
		$overtime_profile->weekend_days_bonus_ratio= $request->weekend_days_bonus_ratio;
		$overtime_profile->holidays_bonus_ratio =$request->holidays_bonus_ratio;
		$overtime_profile->save();
		Log::info($request->name." Overtime Profile Added By ".auth()->user()->employee->full_name_en);
		return redirect('overtime/profiles/index')->with('success', 'Overtime Profile Profile is successfully added');
	}
	
    public function edit($id){
	
	$overtime_profile = OvertimeProfile::find($id);
	return view('overtime-profile.edit',['overtime_profile'=>$overtime_profile]);
	}
	public function update($id,Request $request){
		$overtime_profile = OvertimeProfile::find($id);
		Log::info($overtime_profile->name." Overtime Profile updated By ".auth()->user()->employee->full_name_en);
		$overtime_profile->name= $request->name;
		$overtime_profile->first_two_hours_time_ratio= $request->first_two_hours_time_ratio;
		$overtime_profile->next_hours_time_ratio = $request->next_hours_time_ratio;
		$overtime_profile->weekend_days_time_ratio= $request->weekend_days_time_ratio;
		$overtime_profile->holidays_time_ratio =$request->holidays_time_ratio;
		$overtime_profile->first_two_hours_bonus_ratio= $request->first_two_hours_bonus_ratio;
		$overtime_profile->next_hours_bonus_ratio = $request->next_hours_bonus_ratio;
		$overtime_profile->weekend_days_bonus_ratio= $request->weekend_days_bonus_ratio;
		$overtime_profile->holidays_bonus_ratio =$request->holidays_bonus_ratio;
		$overtime_profile->save();
		return redirect('overtime/profiles/index')->with('success', 'Overtime Profile is successfully updated');
	}
	 public function delete($id){
	
	$overtime_profile = OvertimeProfile::find($id);
	Log::info($overtime_profile->name." Overtime Profile deleted By ".auth()->user()->employee->full_name_en);
    $overtime_profile->delete(); 
	return back()->with('success', 'Overtime Profile is successfully deleted');
	}
	 public function deleteSelected(Request $request)
	{
      $overtime_profiles_ids = $request->get('overtime_profiles_ids');
        foreach($overtime_profiles_ids as $id){
			$this->delete($id);
		}
      return redirect("overtime/profiles/index")->with('success','Selected Overtime Profiles Are Successfully Deleted');
    }
	public function export()  
   {
	   return Excel::download(new OvertimeProfileExport , 'Overtime_Profile.xlsx');
	   Log::info(" Overtime Profile File Exported By ".auth()->user()->employee->full_name_en);
	   return back()->with('success', ' Overtime Profile are exported successfully');
   }
   /*******  export users excel sheet with heading to insert ***********/
	 public function export_insert() 
   {
	   return Excel::download(new OvertimeProfileInsert , 'Overtime_Heading.xlsx');
	   Log::info(" Overtime Profile Inserting File Exported By ".auth()->user()->employee->full_name_en);
	   return back();
   }
    /*******  import users excel sheet ***********/
	 public function import(Request $request)   
    {
	
        $this->validate($request, [
      'Overtime_Profile_import'  => 'required|mimes:xls,xlsx'
     ]);
	    
     Excel::import(new OvertimeProfileImport, request()->file('Overtime_Profile_import'));
	 Log::info(" Overtime Profile File Imported By ".auth()->user()->employee->full_name_en);
     return back()->with('success', 'Excel Data Imported successfully.');
	
	}
}
	