@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
 <form method="POST" action="{{url('employee/permissions/update/'.$employee_permission->id)}}" id="form1" style="margin-bottom:10px;">
 @csrf
   <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  Edit Employee Permission
              </a>
          </p>
 <div class="collapse show" id="basic-info-div">
 <div class="card card-body basic-info-content">
                 
 <div class="row">
   <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label  class="role col-sm-4 col-form-label">Employee:</label>
  
      <select  class="form-control"name="employee_id" id='selEmployee' required>
	   <option value="{{$employee_permission->employee->id}}">{{$employee_permission->employee->full_name_en}}</option>
	  @foreach($employees as $employee)
	  <option value="{{$employee->id}}">{{$employee->full_name_en}}</option>
	  @endforeach
	  </select>
    </div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
	 <label  class="role col-sm-4 col-form-label">Permission Type :</label>
  
      <select  class="form-control"name="permission_id" required>
	  <option value="{{$employee_permission->permission->id}}">{{$employee_permission->permission->type}}</option>
	  @foreach($permissions as $permission)
	  <option value="{{$permission->id}}">{{$permission->type}}</option>
	  @endforeach
	  </select>
    </div>
	 </div>
  <div class="row">
 <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label  class="role col-sm-4 col-form-label">Day :</label>
  
      <input type="date" class="form-control" name="day" value="{{$employee_permission->day}}"  required>
    </div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
	  <label  class="role col-sm-4 col-form-label">From :</label>
      <input type="time" class="form-control" name="from" value="{{$employee_permission->from}}" required>
  
    </div>
  </div>
   <div class="row">
 <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label  class="role col-sm-4 col-form-label">To :</label>
  
      <input type="time" class="form-control" name="to" value="{{$employee_permission->to}}" required>
    </div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
	  <label  class="role col-sm-4 col-form-label">Status :</label>
      <select  class="form-control"name="status" required>
	   <option value="{{$employee_permission->status}}">{{$employee_permission->status}}</option>
	  <option value="pending">Pending</option>
	  <option value="approved">Approved</option>
	  <option value="manger_permission">Manager Permission</option>
	  </select>
    </div>
  </div>
     </div>
	  <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">edit</button>
	  </div>
	  
  </form>
   </div>
 
@endsection