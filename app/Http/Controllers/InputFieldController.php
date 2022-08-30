<?php

namespace App\Http\Controllers;
use App\Role;
use App\Employee;
use App\EmployeeInputField;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Log;
class InputFieldController extends Controller
{
	public function index(){
    $fields = EmployeeInputField::all();
      return view('input-fields.index',compact('fields'));
	}

	public function store(Request $request){
		
		$fields_names = EmployeeInputField::select('name')->get();
		$fields=[];
		foreach($fields_names as $fields_name){
			$fields[] = $fields_name->name;
		}
		 $this->validate($request, [
        'name' => 'required|alpha_dash'
        ]);
		if(!in_array($request->name,$fields)){
		$employee_input_field = new EmployeeInputField;
		$employee_input_field->name = $request->name;
		$employee_input_field->type = $request->type;
		$employee_input_field->is_mandatory = $request->is_mandatory;
		$employee_input_field->save();
		Log::info(" Employee Input Field (".$request->name.") Added By ".auth()->user()->employee->full_name_en);
		}
		else{
			  return back()->with('error', 'input already exsists');
		}
		$employees_columns = Schema::getColumnListing('employees');
		if(!in_array($request->name,$employees_columns)){
		$name = $request->name;	
		Schema::table('employees', function (Blueprint $table) use($name) {
		    $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->string($name)->nullable();
	   });
	    
		}
	   return back()->with('success', 'input created successfully');
		
	}
	
   public function update($id , Request $request)
   {
	 $fields_names = EmployeeInputField::select('name')->get();
	 $employee_input_field = EmployeeInputField::find($id);
		$fields=[];
		foreach($fields_names as $fields_name){
			$fields[] =$fields_name->name;
		}
		if(!in_array($request->name,$fields)){
		Log::info(" Employee Input Field (".$employee_input_field->name.") updated By ".auth()->user()->employee->full_name_en);
		$employee_input_field->name = $request->name;
		$employee_input_field->type = $request->type;
		$employee_input_field->is_mandatory = $request->is_mandatory;
		$employee_input_field->save();
		
		}
		else{
			  return back()->with('error', 'input already exsists');
		}
		$employees_columns = Schema::getColumnListing('employees');
		if(!in_array($request->name,$employees_columns)){
		$new_name = $request->name;	
		$old_name = $employee_input_field->name;
		Schema::table('employees', function (Blueprint $table) use($old_name,$new_name) {
		    $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->renameColumn($old_name ,$new_name);
	   });
		}
		
	   return back()->with('success', 'input updated successfully');

   }
   public function delete($id)                      
    {
        $employee_input_field = EmployeeInputField::findOrFail($id);
		 Log::info(" Employee Input Field (".$employee_input_field->name.") deleted By ".auth()->user()->employee->full_name_en);
        $employee_input_field->delete();

      return back()->with('success', 'input deleted successfully');
    }
	
}