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
        <form method="POST" action="{{url('attendance/store')}}" enctype="multipart/form-data">
            @csrf

            <p class="fullwidth-collapse-div">
                <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                    <i class="fas fa-database"></i>
                    {{ __('attendance.add_employee_attendance') }}
                </a>
            </p>
            <div class="collapse show" id="basic-info-div">
                <div class="card card-body basic-info-content">


                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.employee') }}</label>
                            <select id='selEmployee' class="form-control"  name="employee_id"  required>
							@foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->full_name_en}}</option>
								@endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.day') }}</label>
                            <input type="date" class="form-control" name="day" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.from') }} </label>
                            <input type="time" class="form-control" name="from" >
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.to') }}</label>
                            <input type="time" class="form-control" name="to" >
                        </div>
                    </div>
					 <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label"> {{ __('attendance.overtime_profile') }} </label>
							 <select class="form-control" name="overtime_profile_id" required>
							  @foreach( $overtime_profiles as  $overtime_profile)
						  <option value="{{$overtime_profile->id}}">{{$overtime_profile->name}} </option>
						   @endforeach
						   </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.work_schedule_profile') }}</label>
							<select class="form-control" name="work_schedule_id" required>
						     @foreach($work_schedules as  $work_schedule)
						  <option value="{{$work_schedule->id}}">{{$work_schedule->name}} </option>
						   @endforeach
						   </select>
                            
                        </div>
                    </div>
					<div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.start') }} </label>
                            <input type="date" class="form-control" name="start">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.end') }}</label>
                            <input type="date" class="form-control" name="end" >
                        </div>
                    </div>
                    
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">{{ __('attendance.add') }}</button>
            <form>
    </div>
@endsection
