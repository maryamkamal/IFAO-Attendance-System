@extends('layouts.home')

@section('content')
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

<!---------------- role add section  !------------------->
 <div class="add-new-product-div">
 <form method="POST" action="{{url('input/fields/store')}}" id="form1" style="margin-bottom:10px;">
 @csrf
   <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  Add Input Fields
              </a>
          </p>
 <div class="collapse hide" id="basic-info-div">
 <div class="card card-body basic-info-content">
     <div class="row">
 <div class="form-group col-lg-12 col-md-6 col-sm-12">
    <h6>* Note: Write coulmn name in english lower case without spaces or special characters ,Separate words with underscores.  </h6>
     
    </div>  
</div> 	
  <div class="row">
 <div class="form-group col-lg-4 col-md-6 col-sm-12">
    <label  class="col-form-label">Input Name :</label>
      <input type="text" class="form-control"  name="name" required>
    </div>
	<div class="form-group col-lg-4 col-md-6 col-sm-12" >
    <label class="col-form-label">Input Type :</label>
      <select class="form-select form-control"  name="type" required>
	  <option value="text">Text </option>
	  <option value="file">File </option>
	  <option value="number">Number </option>
	  <option value="date">Date </option>
	  <option value="time">Time </option>
	  </select>
    </div>
	<div class="form-group col-lg-4 col-md-6 col-sm-12">
	<label  class="form-check-label">Mandatory :</label></br>
	  <input type="checkbox" class="form-check-input" name="is_mandatory" style="margin:20px 30px" value="1">
    
  
    
    </div>
  </div>

	 <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">Add</button>
     </div>
	  </div>
	  
  </form>
   </div>
<!--      input fields list and update --->
     <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  Input Fields
              </a>
          </p>
 <div class="collapse show" id="basic-info-div">
 <div class="card card-body basic-info-content">
                 
  <!---- dynamc input fields --->
       @foreach( $fields as  $field)
	    <form method="POST" action="{{url('input/fields/update/'.$field->id)}}" id="form1" style="margin-bottom:10px;">
                             @csrf
	    <div class="row">
 <div class="form-group col-lg-3 col-md-6 col-sm-12">
    <label  class="col-form-label">Input Name :</label>
      <input type="text" class="form-control" name="name" value="{{$field->name}}" required>
    </div>
	<div class="form-group col-lg-3 col-md-6 col-sm-12" >
    <label class="col-form-label">Input Type :</label>
      <select class="form-select form-control" name="type" required>
	  <option value="{{$field->type}}">{{$field->type}}</option>
	   <option value="text">Text </option>
	  <option value="file">File </option>
	  <option value="number">Number </option>
	  <option value="date">Date </option>
	  <option value="time">Time </option>
	  </select>
    </div>
	<div class="form-group col-lg-2 col-md-6 col-sm-12">
	<label  class="form-check-label">Mandatory :</label></br>
	  <input type="checkbox" class="form-check-input" name="is_mandatory" value="1" style="margin:20px 30px" @if($field->is_mandatory ==1)checked @endif >
    </div>
	                    <div class="form-group col-lg-1 col-md-6 col-sm-12">
						  <span class="edit-btn">
						  
                         <button type="submit" class="btn btn-success edit-btn" style="background-color: #376861 !important;" value="update"> update</button>
                         </span>
                        </div>
	                   <div class="form-group col-lg-1 col-md-6 col-sm-12">
                        <span class="delete-btn">
                        <a href="{{url('input/fields/delete/'.$field->id)}}" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
                        <i class="fas fa-trash-alt"></i>
                         </a>
                        </span>
	                   </div>
  </div>
	   @endforeach
     </div>
	  </div>
@endsection