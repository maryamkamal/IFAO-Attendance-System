@extends('layouts.home')

@section('content')
    @if ($message = Session::get('success'))

        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('error'))

        <div class="alert alert-danger alert-block">

            <button type="button" class="close" data-dismiss="alert">×</button>

            <strong>{{ $message }}</strong>

        </div>
    @endif
    <div class="add-new-product-div">
        <form method="POST" action="{{url('attendance/update/'.$attendance->id)}}" enctype="multipart/form-data">
            @csrf

            <p class="fullwidth-collapse-div">
                <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                    <i class="fas fa-database"></i>
                    {{ __('attendance.edit_employee_attendance') }}
                </a>
            </p>
            <div class="collapse show" id="basic-info-div">
                <div class="card card-body basic-info-content">


                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.employee') }}</label>
                            <select  class="form-control" id='selEmployee' name="employee_id"  required>
                                <option value="{{$attendance->employee_id}}">{{$attendance->employee->full_name_en}}</option>
								@foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->full_name_en}}</option>
								@endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label"> {{ __('attendance.day') }}</label>
                            <input type="date" class="form-control" name="day"  value="{{$attendance->day}}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.from') }} </label>
                            <input type="time" class="form-control" name="from"  value="{{$attendance->from}}">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.to') }}</label>
                            <input type="time" class="form-control" name="to"  value="{{$attendance->to}}">
                        </div>
                    </div>
					 <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label"> {{ __('attendance.overtime_profile') }} </label>
							 <select class="form-control" name="overtime_profile_id" required>
						   <option value="{{$attendance->employee->overtime_profile_id}}">
						   @if($attendance->overtime_profile_id)
							{{ $attendance->overtime_profile->name}}
  					      @endif
						</option>
						      @foreach( $overtime_profiles as  $overtime_profile)
						  <option value="{{$overtime_profile->id}}">{{$overtime_profile->name}} </option>
						   @endforeach
						   </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.work_schedule_profile') }}</label>
							<select class="form-control" name="work_schedule_id" required>
						   <option value="{{$attendance->employee->work_schedule_id}}">
						  @if($attendance->work_schedule_id)
							{{$attendance->work_schedule->name}} @endif
						   </option>
						     @foreach($work_schedules as  $work_schedule)
						  <option value="{{$work_schedule->id}}">{{$work_schedule->name}} </option>
						   @endforeach
						   </select>
                            
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">{{ __('attendance.update') }}</button>
            <form>
    </div>
@endsection
