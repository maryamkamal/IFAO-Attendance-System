@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
 <form method="POST" action="{{url('leaves/store')}}" id="form1" style="margin-bottom:10px;">
 @csrf
   <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  Add Leave
              </a>
          </p>
 <div class="collapse show" id="basic-info-div">
 <div class="card card-body basic-info-content">
                 
 <div class="row">
 <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label for="role" class="role col-sm-4 col-form-label">Leave Type :</label>
  
      <input type="text" class="form-control" style="background-color: #fff;" name="type">
    </div>
	</div>
	 <div class="row">
	<div class="form-group col-lg-6 col-md-6 col-sm-12" style="margin:20px;">
	 <input type="checkbox" class="form-check-input" style="background-color: #fff;" name="is_paid" value="1" checked>
    <label class="form-label">Paid </label>
    </div>
  </div>
  <div class="row">
	<div class="form-group col-lg-6 col-md-6 col-sm-12" style="margin:20px;">
   <input type="checkbox"class="form-check-input" style="background-color: #fff;" name="solde_deduction" value="1"  >
    <label class="form-label">Solde Deduction </label>
    </div>
  </div>
	 <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">Add</button>
	  </div>  
  </form>
   </div>
 
@endsection