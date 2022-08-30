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

  <div class="row">
 
                 
                <input type="text" class="form-control" style="width:400px;margin:auto; border: 2px solid" id="code" placeholder="Code">
                
       
    </div>

 
    <div class="system-table-div goods-table-div" >
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"id="employee_data">
         
      </div>
  
    </div>
	
    </div>
  
@endsection