@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
 <form method="POST" action="{{url('employee/solde/deduction/store')}}" id="form1" style="margin-bottom:10px;">
 @csrf
   <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                 Deduct Employee's Solde
              </a>
          </p>
 <div class="collapse show" id="basic-info-div">
 <div class="card card-body basic-info-content">
                 
 <div class="row">
   <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label  class="role col-sm-4 col-form-label">Employee:</label>
  
      <select  class="form-control"name="employee_id" id='selEmployee' required>
	  @foreach($employees as $employee)
	  <option value="{{$employee->id}}">{{$employee->full_name_en}}</option>
	  @endforeach
	  </select>
    </div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
	 <label  class="role col-sm-4 col-form-label">Deducted Solde :</label>
      <input type="float" class="form-control" name="deducted_solde" required>
	  
    </div>
	 </div>
  <div class="row">
 <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label  class="role col-sm-4 col-form-label">Note :</label>
  
      <textarea type="date" class="form-control" col="5" row="3" name="note" ></textarea>
    </div>
  </div>


	 <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">Add</button>
	  </div>
	  
  </form>
   </div>
 
@endsection