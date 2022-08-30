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
 <form method="POST" action="{{url('roles/update/'.$role->id)}}" id="form1" style="margin-bottom:10px;">
 @csrf
  <div class="row">
 <div class="form-group col-lg-6 col-md-6 col-sm-12">
    <label for="role" class="role col-sm-4 col-form-label">Role Name :</label>
  
      <input type="text" class="form-control" style="background-color: #fff;" name="name" id="role" value="{{$role->name}}" required>
    </div>
  </div>
   <div class="system-table-div goods-table-div">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
              <h5 class="card-header table-header">Authorities</h5>
              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered first data-table" >
                          <thead>

                              <tr>
							  <th scope="col" class="product-name-title text-center">Page</th>
                                  <th scope="col" class="product-name-title text-center">View All</th>
                                  <th scope="col" class="category-title text-center">Modify</th>
								  <th scope="col" class="options-title text-center">Export</th>
								  <th scope="col" class="options-title text-center">View Only Employee Data</th>
                              </tr>
                          </thead>
                          <tbody>
						  @php($counter = 0)
						   @php($count = count($pages))
						 @while($counter < $count)
						  <tr>
						  <td class="check-product-div text-center">
						  {{$pages[$counter]['name'] }}
						  </td>
						   <td class="check-product-div text-center">
						    <input type="checkbox" class="form-check-input" name="view[{{$counter}}]" value="1" style="margin-left:50px" @if($role->authority('view',$pages[$counter]['name'])==1) checked @endif>
						  </td>
						    <td class="check-product-div text-center">
							 <input type="checkbox" class="form-check-input" name="modify[{{$counter}}]"  value="1" style="margin-left:50px;" @if($role->authority('modify',$pages[$counter]['name'])==1) checked @endif>
						  </td>
						   <td class="check-product-div text-center">
						   <input type="checkbox" class="form-check-input" name="export[{{$counter}}]" value="1" style="margin-left:50px" @if($role->authority('export',$pages[$counter]['name'])==1) checked @endif>
						  </td>
						   <td class="check-product-div text-center">
						   <input type="checkbox" class="form-check-input" name="view_only_employee_data[{{$counter}}]" value="1" style="margin-left:50px" @if($role->authority('view_only_employee_data',$pages[$counter]['name'])==1) checked @endif>
						  </td>
						  </tr>
						   @php ($counter++)
						   @endwhile
						  
                          </tbody>
                      </table>
                  </div>
              </div>
			   
          </div>
      </div>
  </div>
   <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">Edit</button>
   </form>
@endsection