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

<div class="table-outer-options-div">
    <div class="row">
	 <div class="col-lg-6 col-md-6 col-sm-12 add-product-div">
	 </div>
        <div class="col-lg-6 col-md-6 col-sm-12 add-product-div">
            <a href="{{url('roles/create')}}" type="button" class="btn btn-primary add-btn" style="background-color: #376861 !important;">
                <i class="fas fa-plus-circle"></i>
                <span>Add Role</span>
            </a>
        </div>
        </div>
    </div>
</div>
   
   <!---------------- role table  !------------------->
     <div class="system-table-div goods-table-div">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
              <h5 class="card-header table-header">Roles</h5>
              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered first data-table" >
                          <thead>

                              <tr>
							  <th scope="col" class="product-name-title text-center">ID</th>
                                  <th scope="col" class="product-name-title text-center">Name</th>
								  <th scope="col" class="options-title text-center">actions</th>
                              </tr>
                          </thead>
                          <tbody>
						  @foreach($roles as $role)
						  <tr>
						  <td class="check-product-div text-center">
						    {{$role->id}}
						  </td>
						   <td class="check-product-div text-center">
						    {{$role->name}}
						  </td>
						    
						   <td class="check-product-div text-center">
						  <span class="edit-btn">
                         <a href="{{url('roles/edit/'.$role->id)}}" class="btn btn-success edit-btn" style="background-color: #376861 !important;">
                         <i class="far fa-edit"></i>
                         </a>
                         </span>

                        <span class="delete-btn">
                        <a href="{{url('roles/delete/'.$role->id)}}" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
                        <i class="fas fa-trash-alt"></i>
                         </a>
                        </span>
						  </td>
						  </tr>
						   @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection