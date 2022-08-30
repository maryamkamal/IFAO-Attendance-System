@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
 <form method="POST" action="{{url('leaves/update/'.$leave->id)}}" id="form1" style="margin-bottom:10px;">
 @csrf
   <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  edit Leave
              </a>
          </p>
 <div class="collapse show" id="basic-info-div">
 <div class="card card-body basic-info-content">
                 
  <div class="row">
 <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label for="role" class="role col-sm-4 col-form-label">Leave Type  :</label>
  
      <input type="text" class="form-control" name="type" value="{{$leave->type}}">
    </div>
	 </div>
	 <div class="row">
	<div class="form-group col-lg-6 col-md-6 col-sm-12" style="margin:20px;">
   <input type="checkbox"class="form-check-input" style="background-color: #fff;" name="is_paid" value="1" @if($leave->is_paid ==1) checked @endif >
    <label class="form-label">Paid </label>
    </div>
  </div>
  <div class="row">
	<div class="form-group col-lg-6 col-md-6 col-sm-12" style="margin:20px;">
   <input type="checkbox"class="form-check-input" style="background-color: #fff;" name="solde_deduction" value="1" @if($leave->sold_deduction ==1) checked @endif >
    <label class="form-label">Solde Deduction </label>
    </div>
  </div>
     <!-- attendance screens section starts -->

     </div>
	  <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">edit</button>
	  </div>
	  
  </form>
   </div>
 
@endsection