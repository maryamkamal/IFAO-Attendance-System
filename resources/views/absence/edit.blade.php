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
        <form method="POST" action="{{url('absence/update/'.$absence->id)}}" enctype="multipart/form-data">
            @csrf

            <p class="fullwidth-collapse-div">
                <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                    <i class="fas fa-database"></i>
                    Edit Employee Absence
                </a>
            </p>
            <div class="collapse show" id="basic-info-div">
                <div class="card card-body basic-info-content">


                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Employee Name</label>
                            <select  class="form-control" id='selEmployee' name="employee_id"  required>
                                <option value="{{$absence->employee_id}}">{{$absence->employee->full_name_en}}</option>
								@foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->full_name_en}}</option>
								@endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label">Day</label>
                            <input type="date" class="form-control" name="day"  value="{{$absence->day}}" required>
                        </div>
                    </div>
                   
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">update</button>
            <form>
    </div>
@endsection
