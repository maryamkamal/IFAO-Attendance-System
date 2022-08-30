@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
   <form method="POST" action="{{url('work/schedules/update/'.$work_schedule_profile->id)}}" enctype="multipart/form-data">
		@csrf
      
		  <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  Update Work schedule Profile
              </a>
          </p>
          <div class="collapse show" id="basic-info-div">
              <div class="card card-body basic-info-content">
                 
				   <div class="row">
                      
                      <div class="form-group col-lg-3">
                          <label class="form-label">schedule Name</label>
                          <input type="text" class="form-control" name="name" value="{{$work_schedule_profile->name}}" required>
                      </div>
                     <div class="form-group col-lg-3">
                          <label class="form-label">start</label>
                          <input type="time" class="form-control" name="start" value="{{$work_schedule_profile->start}}" >
                      </div>
					   <div class="form-group col-lg-3">
                          <label class="form-label">End</label>
                          <input type="time" class="form-control"  name="end" value="{{$work_schedule_profile->end}}" >
                      </div>
					  @php($work_days = unserialize($work_schedule_profile->work_days) )
					
                  </div>
				   <div class="row">
                      <div class="form-group col-lg-3">
                          <label class="form-label"> Work Duration</label>
                          <input type="float" class="form-control" name="work_duration" value="{{$work_schedule_profile->work_duration}}" >
                      </div>
					   <div class="form-group col-lg-3" style="margin-left:30px;">
					  @if($work_days != null)
                         <input type="checkbox" class="form-check-input" name="days[]" value="Saturday" @if(in_array('Saturday',$work_days)) checked @endif>
						  <label class="form-label">Saturday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Sunday" @if(in_array('Sunday',$work_days)) checked @endif>
						  <label class="form-label">Sunday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Monday" @if(in_array('Monday',$work_days)) checked @endif>
						  <label class="form-label">Monday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Tuesday" @if(in_array('Tuesday',$work_days)) checked @endif>
						  <label class="form-label">Tuesday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Wednesday" @if(in_array('Wednesday',$work_days)) checked @endif>
						  <label class="form-label">Wednesday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Thursday" @if(in_array('Thursday',$work_days)) checked @endif>
						  <label class="form-label">Thursday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Friday" @if(in_array('Friday',$work_days)) checked @endif>
						  <label class="form-label">Friday</label>
						  @else 
						  <input type="checkbox" class="form-check-input" name="days[]" value="Saturday" >
						  <label class="form-label">Saturday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Sunday">
						  <label class="form-label">Sunday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Monday">
						  <label class="form-label">Monday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Tuesday">
						  <label class="form-label">Tuesday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Wednesday">
						  <label class="form-label">Wednesday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Thursday">
						  <label class="form-label">Thursday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Friday">
						  <label class="form-label">Friday</label>
						@endif
                      </div>
					  </div>
				</div>   
          </div>
		   <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">update</button>
 </form>
</div>
@endsection
