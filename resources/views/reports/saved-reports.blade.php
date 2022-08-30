@extends('layouts.home')

@section('content')
    <style>
        button {
            color: #1b1d20;
            background-color: transparent;
            background-repeat: no-repeat;
            border: none;
            cursor: pointer;
            overflow: hidden;
            outline: none;
        }</style>
    <!----------------success & error meessage  !------------------->
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

    <div class="container-fluid">
        <div class="row flex-nowrap">
           
            <div class="col py-10 pt-2">
                <form action="{{url('reports/saved/result')}}" method="POST">
                    @csrf
                <div class="card card-body basic-info-content">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="form-label"> Report Name </label>
                            <select  class="form-control" name="report_id" required>
							<option> Choose Report </option>
							@foreach($savedReports as $savedReport )
							<option value="{{$savedReport->id}}">{{$savedReport->report_name}} </option>
							@endforeach
							</select>
                        </div>
                    </div>
                </div>
            <button type="submit" class="btn btn-primary btn-block" id="runQuery" style="background-color: #376861 !important;">Run Query</button>
                </form>

                </div>
              


            </div>
    </div>
@endsection
