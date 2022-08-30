@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
 <form method="POST" action="{{url('employee/permissions/store')}}" id="form1" style="margin-bottom:10px;">
 @csrf
   <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  Add Employee Permission
              </a>
          </p>
 <div class="collapse show" id="basic-info-div">
 <div class="card card-body basic-info-content">
                 
 <div class="row">
   <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label  class="role col-sm-4 col-form-label">Employee:</label>
  
      <select  class="form-control"name="employee_id" id='selEmployee' required>
	  @foreach($employees as $employee)
	  <option value="{{$employee->id}}">{{$employee->full_name_en}}</option>
	  @endforeach
	  </select>
    </div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
	 <label  class="role col-sm-4 col-form-label">Permission Type :</label>
  
      <select  class="form-control"name="permission_id" required>
	  @foreach($permissions as $permission)
	  <option value="{{$permission->id}}">{{$permission->type}}</option>
	  @endforeach
	  </select>
    </div>
	 </div>
  <div class="row">
 <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label  class="role col-sm-4 col-form-label">Day :</label>
  
      <input type="date" class="form-control" name="day" required>
    </div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
	  <label  class="role col-sm-4 col-form-label">From :</label>
      <input type="time" class="form-control"  name="from" required>
  
    </div>
  </div>
   <div class="row">
 <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label  class="role col-sm-4 col-form-label">To :</label>
  
      <input type="time" class="form-control"  name="to" required>
    </div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
	  <label  class="role col-sm-4 col-form-label">Status :</label>
      <select  class="form-control"name="status" required>
	  <option value="pending">Pending</option>
	  <option value="approved">Approved</option>
	  <option value="manger_permission">Manager Permission</option>
	  </select>
    </div>
  </div>

	 <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">Add</button>
	  </div>
	  
  </form>
   </div>
 
@endsection