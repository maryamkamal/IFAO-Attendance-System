@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
   <form method="POST" action="{{url('employees/salaries/update/'.$employee_salary->id)}}" enctype="multipart/form-data">
		@csrf

		  <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                 Edit Employee Salary
              </a>
          </p>
          <div class="collapse show" id="basic-info-div">
              <div class="card card-body basic-info-content">

                  <div class="row">
                      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">Employee</label>
                          <select  class="form-control"name="employee_id" id='selEmployee' required>
						   <option value="{{$employee_salary->employee_id}}">{{$employee_salary->employee->full_name_en}}</option>
	                      @foreach($employees as $employee)
	                      <option value="{{$employee->id}}">{{$employee->full_name_en}}</option>
	                       @endforeach
	                       </select>
                      </div>
					 
                      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label"> Salary</label>
                          <input type="text" class="form-control"  name="salary" value="{{$employee_salary->salary}}" required>
                      </div>
					  </div>
					   <div class="row">
					  <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label"> Start</label>
                          <input type="date" class="form-control" name="start" value="{{$employee_salary->start}}"required>
                      </div>
					  <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label"> End</label>
                          <input type="date" class="form-control" name="end" value="{{$employee_salary->end}}" required>
                      </div>
                  </div>
				  
                   
              </div>
          </div>

		   <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">update</button>
<form>
</div>
@endsection
