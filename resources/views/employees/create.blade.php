@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
   <form method="POST" action="{{url('employees/store')}}" enctype="multipart/form-data">
		@csrf

		  <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  Add New Employee
              </a>
          </p>
          <div class="collapse show" id="basic-info-div">
              <div class="card card-body basic-info-content">

                  <div class="row">
                      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">full_name_en</label>
                          <input type="text" class="form-control"  name="full_name_en" required>
                      </div>
					  <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">code</label>
                          <input type="text" class="form-control" name="code" required>
                      </div>
                  </div>
				   <div class="row">
					  <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">overtime profiles</label>
                          <select class="form-control" name="overtime_profile_id" required>
						     @foreach( $overtime_profiles as  $overtime_profile)
						  <option value="{{$overtime_profile->id}}">{{$overtime_profile->name}} </option>
						   @endforeach
						   </select>
                      </div>
					   <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">work schedules</label>
                          <select class="form-control" name="work_schedule_id" required>
						     @foreach($work_schedules as  $work_schedule)
						  <option value="{{$work_schedule->id}}">{{$work_schedule->name}} </option>
						   @endforeach
						   </select>
                      </div>
                  </div>
				  <div class="row">
                      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">Current Salary</label>
                          <input type="text" class="form-control"  name="salary" required>
                      </div>
					  <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">Current Salary Start</label>
                          <input type="date" class="form-control" name="salary_start" required>
                      </div>
                  </div>
				  <div class="row">
                      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">Vacations Hours Balance</label>
                          <input type="text" class="form-control"  name="solde">
                      </div>
					  <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">Delay Balance</label>
                          <input type="text" class="form-control" name="delay_balance">
                      </div>
                  </div>
                    
                   @php($counter = count($input_fields))
				    @php($count = 0 )
				   @while($count < $counter)
					   <div class="row">
					  <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">{{$input_fields[$count]->name}}</label>
                          <input type="{{$input_fields[$count]->type}}" class="form-control" name="{{$input_fields[$count]->name}}" @if($input_fields[$count]->is_mandatory ==1) required @endif>
                      </div>
					    @php(++$count )
					  @if($count < $counter)
					   <div class="form-group col-lg-6 col-md-6 col-sm-12">
                           <label class="form-label">{{$input_fields[$count]->name}}</label>
                          <input type="{{$input_fields[$count]->type}}" class="form-control" name="{{$input_fields[$count]->name}}" @if($input_fields[$count]->is_mandatory ==1) required @endif>
                      </div>
					   @php(++$count )
					  @endif
                  </div>
                @endwhile
				 <div class="row">
					  <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">Image</label>
                          <input type="file" class="form-control" name="image">
                      </div>
				<div class="form-group col-lg-6 col-md-6 col-sm-12" >
				<label class="form-label"> holiday Profile</label>
	               <input type="radio" class="form-check-input" style="background-color: #fff;" name="holiday_type" value="1" >
                    <label class="form-label">Islamic holidays</label>
          
	               <input type="radio" class="form-check-input" style="background-color: #fff;" name="holiday_type" value="2" >
                    <label class="form-label">Christian Holidays </label>
                    </div>
                </div>
				 <div class="row">
                      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">RFID Code</label>
                          <input type="text" class="form-control"  name="rfid_id">
                      </div>
					 
                  </div>
              </div>
          </div>

		   <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">Add</button>
<form>
</div>
@endsection
