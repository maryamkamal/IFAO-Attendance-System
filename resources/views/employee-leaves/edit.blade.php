@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
 <form method="POST" action="{{url('employee/leaves/update/'.$employee_leave->id)}}" id="form1" style="margin-bottom:10px;">
 @csrf
   <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                 {{__('employee-leaves.Edit Employee Leave')}} 
              </a>
          </p>
 <div class="collapse show" id="basic-info-div">
 <div class="card card-body basic-info-content">

 <div class="row">
   <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label  class="role col-sm-4 col-form-label">{{__('employee-leaves.Employee')}}</label>

      <select  class="form-control"name="employee_id" id='selEmployee' required>
	   <option value="{{$employee_leave->employee->id}}">{{$employee_leave->employee->full_name_en}}</option>
	  @foreach($employees as $employee)
	  <option value="{{$employee->id}}">{{$employee->full_name_en}}</option>
	  @endforeach
	  </select>
    </div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
	 <label  class="role col-sm-4 col-form-label">{{__('employee-leaves.Leave')}}</label>

      <select  class="form-control"name="leave_id" required>
	  <option value="{{$employee_leave->leave->id}}">{{$employee_leave->leave->type}}</option>
	  @foreach($leaves as $leave)
	  <option value="{{$leave->id}}">{{$leave->type}}</option>
	  @endforeach
	  </select>
    </div>
	 </div>
  <div class="row">
 <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label  class="role col-sm-4 col-form-label">{{__('employee-leaves.from')}}</label>
      <input type="date" class="form-control" name="from" value="{{$employee_leave->from}}"  required>
    </div>
      <div class="form-group col-lg-6 col-md-6 col-sm-12">
          <label  class="role col-sm-4 col-form-label">{{__('employee-leaves.to')}}</label>
          <input type="date" class="form-control" name="to" value="{{$employee_leave->to}}"  required>
      </div>
  </div>
      <div class="row">
	   <div class="form-group col-lg-6 col-md-6 col-sm-12">
	    <label  class="role col-sm-4 col-form-label">{{__('employee-leaves.status')}}</label>
        <select  class="form-control"name="status" required>
	       <option value="{{$employee_leave->status}}">{{$employee_leave->status}}</option>
	         <option value="pending">{{__('employee-leaves.Pending')}} </option>
	         <option value="approved">{{__('employee-leaves.Approved')}} </option>
	         <option value="manger_permission">{{__('employee-leaves.Manager approve')}} </option>
	    </select>
      </div>
  </div>
   <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">{{__('employee-leaves.edit')}} </button>
     </div>
	  </div>

  </form>
   </div>

@endsection
