<?php

namespace App\Http\Controllers;
use App\WorkScheduleProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkScheduleProfileExport;
use App\Exports\WorkScheduleProfileInsert;
use App\Imports\WorkScheduleProfileImport;
use DataTables;
use Log;
class WorkScheduleProfileController extends Controller
{
	
	public function index(Request $request){
	$work_schedule_profiles = WorkScheduleProfile::all();
         if ($request->ajax()) {
     return Datatables::of($work_schedule_profiles)
     ->addIndexColumn()
	 ->addColumn('check_all', function($work_schedule_profile){

   $check_all = ' <input type="checkbox" class="checkbox" name="work_schedule_profiles_ids[]" value="'.$work_schedule_profile->id.'"> ';

   return $check_all;
})
   ->addColumn('action', function($work_schedule_profile){
if(auth()->user()->authority('modify','work_schedule_profiles')==1){
   $btn = ' <span class="edit-btn">
            <a href="work/schedules/edit/'.$work_schedule_profile->id.'" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
            <i class="far fa-edit"></i>
            </a>
            </span>

            <span class="delete-btn">
             <a href="work/schedules/delete/'.$work_schedule_profile->id.'" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
              <i class="fas fa-trash-alt"></i>
             </a>
            </span>';

   return $btn;
}
})
->addColumn('work_days', function($work_schedule_profile){
if(unserialize($work_schedule_profile->work_days) != null){
$work_days = unserialize($work_schedule_profile->work_days) ;
	 					  
		 return	$work_days;				 
}
else{
	 return "";
}
})

->rawColumns(['action','check_all','work_days'])
->make(true);
}
      	return view('work-scheduale-profile.index');
	}

	public function create(){
	
	return view('work-scheduale-profile.create');
	}
	public function store(Request $request){
		$work_schedule_profile = new WorkScheduleProfile;
		$work_schedule_profile->name= $request->name;
		$work_schedule_profile->start= $request->start;
		$work_schedule_profile->end= $request->end;
		$work_schedule_profile->work_duration= $request->work_duration;
		$work_schedule_profile->work_days = serialize($request->days);
		$work_schedule_profile->save();
		return redirect('work/schedules/index')->with('success', 'Work Schedule Profile is successfully added');
	}
        public function edit($id,Request $request){
	
	$work_schedule_profile = WorkScheduleProfile::find($id);
	return view('work-scheduale-profile.edit',['work_schedule_profile'=>$work_schedule_profile]);
	}
	public function update($id,Request $request){
		$work_schedule_profile = WorkScheduleProfile::find($id);
		$work_schedule_profile->name= $request->name;
		$work_schedule_profile->start= $request->start;
		$work_schedule_profile->end= $request->end;
		$work_schedule_profile->work_duration= $request->work_duration;
		$work_schedule_profile->work_days = serialize($request->days);
		$work_schedule_profile->save();
		return redirect('work/schedules/index')->with('success', 'Work Schedule Profile is successfully updated');
	}
	 public function delete($id,Request $request){
	
	$work_schedule_profile = WorkScheduleProfile::find($id);
    $work_schedule_profile->delete(); 
	return back()->with('success', 'Work Schedule Profile is successfully deleted');
	}
	 public function deleteSelected(Request $request)
	{
      $work_schedule_profiles_ids = $request->get('work_schedule_profiles_ids');
        WorkScheduleProfile::destroy($work_schedule_profiles_ids);
      return redirect("work/schedules/index")->with('success','Selected Work Schedule Profile Are Successfully Deleted');
    }
	 public function export()  
   {
	   return Excel::download(new WorkScheduleProfileExport , 'Work_Schedule_Profile.xlsx');
	   return back()->with('success', ' Work Schedule Profile are exported successfully');
   }
   /*******  export users excel sheet with heading to insert ***********/
	 public function export_insert() 
   {
	   return Excel::download(new WorkScheduleProfileInsert , 'Work_Schedule_Heading.xlsx');
	   return back();
   }
    /*******  import users excel sheet ***********/
	 public function import(Request $request)   
    {
	
        $this->validate($request, [
      'Work_Schedule_Profile_import'  => 'required|mimes:xls,xlsx'
     ]);
	    
     Excel::import(new WorkScheduleProfileImport, request()->file('Work_Schedule_Profile_import'));
	 
     return back()->with('success', 'Excel Data Imported successfully.');
	
	}
}
	