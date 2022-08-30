@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
  <form method="POST" action="{{url('work/schedules/store')}}" enctype="multipart/form-data">
		@csrf
      
		  <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  Add Work schedule Profile
              </a>
          </p>
          <div class="collapse show" id="basic-info-div">
              <div class="card card-body basic-info-content">
                 
				   <div class="row">
                      <div class="form-group col-lg-3">
                          <label class="form-label">schedule Name</label>
                          <input type="text" class="form-control" name="name" required>
                      </div>
                     <div class="form-group col-lg-3">
                          <label class="form-label">start</label>
                          <input type="time" class="form-control" name="start" >
                      </div>
					   <div class="form-group col-lg-3">
                          <label class="form-label">End</label>
                          <input type="time" class="form-control" name="end">
                      </div>
                  </div>
				   <div class="row">
                      <div class="form-group col-lg-3">
                          <label class="form-label"> Work Duration</label>
                          <input type="float" class="form-control" name="work_duration" >
                      </div>
					   <div class="form-group col-lg-3" style="margin-left:30px;">
                         <input type="checkbox" class="form-check-input" name="days[]" value="Saturday">
						  <label class="form-label">Saturday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Sunday" >
						  <label class="form-label">Sunday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Monday" >
						  <label class="form-label">Monday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Tuesday">
						  <label class="form-label">Tuesday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Wednesday">
						  <label class="form-label">Wednesday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Thursday">
						  <label class="form-label">Thursday</label>
						  <input type="checkbox" class="form-check-input" name="days[]" value="Friday">
						  <label class="form-label">Friday</label>
						 
                      </div>
					  </div>
				  <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">Add</button>
 </form>
</div>
@endsection
