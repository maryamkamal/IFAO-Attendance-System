@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
   <form method="POST" action="{{url('overtime/profiles/update/'.$overtime_profile->id)}}" enctype="multipart/form-data">
		@csrf

		  <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  Update overtime profile
              </a>
          </p>
          <div class="collapse show" id="basic-info-div">
              <div class="card card-body basic-info-content">
			   <div class="row">
                
                      </div>
               <div class="row">
                      <div class="form-group col-lg-6">
                          <label class="form-label"> Overtime Profile Name</label>
                          <input type="text" class="form-control" name="name" name="name" value="{{$overtime_profile->name}}" >
                      </div>
                    
					  </div>
					  <div class="row">
					   <div class="form-group col-lg-6">
                          <label class="form-label"> Working Days first two hours ratio  (Time)</label>
                          <input type="float" class="form-control" name="first_two_hours_time_ratio" value="{{$overtime_profile->first_two_hours_time_ratio}}" >
                      </div>
					   <div class="form-group col-lg-6">
                          <label class="form-label">Working Days next hours ratio  (Time)</label>
                          <input type="float" class="form-control" name="next_hours_time_ratio" value="{{$overtime_profile->next_hours_time_ratio}}" >
                      </div>
					   </div>
					   <div class="row">
					    <div class="form-group col-lg-6">
                          <label class="form-label">Weekend Days ratio  (Time)</label>
                          <input type="float" class="form-control" name="weekend_days_time_ratio" value="{{$overtime_profile->weekend_days_time_ratio}}" >
                      </div>
					   <div class="form-group col-lg-6">
                          <label class="form-label">Holidays ratio  (Time)</label>
                          <input type="float" class="form-control" name="holidays_time_ratio" value="{{$overtime_profile->holidays_time_ratio}}" >
                      </div>
                  </div>
				<div class="row">
					   <div class="form-group col-lg-6">
                          <label class="form-label"> Working Days first two hours ratio  (Bonus)</label>
                          <input type="float" class="form-control" name="first_two_hours_bonus_ratio" value="{{$overtime_profile->first_two_hours_bonus_ratio}}" >
                      </div>
					   <div class="form-group col-lg-6">
                          <label class="form-label">Working Days next hours ratio  (Bonus)</label>
                          <input type="float" class="form-control" name="next_hours_bonus_ratio" value="{{$overtime_profile->next_hours_bonus_ratio}}" >
                      </div>
					   </div>
					   <div class="row">
					    <div class="form-group col-lg-6">
                          <label class="form-label">Weekend Days ratio  (Bonus)</label>
                          <input type="float" class="form-control" name="weekend_days_bonus_ratio" value="{{$overtime_profile->weekend_days_bonus_ratio}}" >
                      </div>
					   <div class="form-group col-lg-6">
                          <label class="form-label">Holidays ratio  (Bonus)</label>
                          <input type="float" class="form-control" name="holidays_bonus_ratio" value="{{$overtime_profile->holidays_bonus_ratio}}" >
                      </div>
                  </div>
					  
				</div>
          </div>
		   <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">update</button>
 </form>
</div>
@endsection
