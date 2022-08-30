@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
 <form method="POST" action="{{url('vacations/update/'.$vacation->id)}}" id="form1" style="margin-bottom:10px;">
 @csrf
   <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  edit Holiday
              </a>
          </p>
 <div class="collapse show" id="basic-info-div">
 <div class="card card-body basic-info-content">

  <div class="row">
 <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label for="role" class="role col-sm-4 col-form-label">Holiday Name  :</label>

      <input type="text" class="form-control" name="name" value="{{$vacation->name}}">
    </div>
  </div>
      <div class="row">
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label for="role" class="role col-sm-4 col-form-label">From :</label>

      <input type="date" class="form-control" style="background-color: #fff;" value="{{$vacation->from}}" name="from" >
    </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-12">
              <label for="role" class="role col-sm-4 col-form-label">To :</label>

              <input type="date" class="form-control" style="background-color: #fff;" value="{{$vacation->to}}" name="to" >
          </div>
  </div>
   <div class="row">
				<div class="form-group col-lg-6 col-md-6 col-sm-12" style="margin:20px;">
				<input type="radio" class="form-check-input" style="background-color: #fff;" name="holiday_type" value="0" @if($vacation->holiday_type == 0) checked @endif >
                    <label class="form-label">General holiday</label>
	               <input type="radio" class="form-check-input" style="background-color: #fff;" name="holiday_type" value="1" @if($vacation->holiday_type ==1) checked @endif >
                    <label class="form-label">Islamic holiday</label>
	               <input type="radio" class="form-check-input" style="background-color: #fff;" name="holiday_type" value="2" @if($vacation->holiday_type ==2) checked @endif >
                    <label class="form-label">Christian Holiday </label>
                    </div>
                </div>
     <!-- attendance screens section starts -->

     </div>
	  <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">edit</button>
	  </div>

  </form>
   </div>

@endsection
