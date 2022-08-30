@extends('layouts.home')

@section('content')

 <div class="add-new-product-div">
   <form method="POST" action="{{url('users/update_user/'.$user->id)}}">
		@csrf
    
		  <p class="fullwidth-collapse-div">
              <a class="btn btn-light" data-toggle="collapse" href="#basic-info-div" role="button" aria-expanded="false" aria-controls="basic-info-div">
                  <i class="fas fa-database"></i>
                  Update User Information
              </a>
          </p>
          <div class="collapse show" id="basic-info-div">
              <div class="card card-body basic-info-content">
                 
                  <div class="row">
                      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label"> Username</label>
                          <input type="text" class="form-control"  value="{{$user->name}}" name="name">
                      </div>
                      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">Email</label>
                          <input type="email" class="form-control" value="{{$user->email}}" name="email">
                      </div>
                  </div>
                 
                  <div class="row">
				   <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label class="form-label">Password</label>
                          <input type="password" class="form-control" name="password">
                      </div>
                      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label for="" class="form-label" id="product-category">Role</label>
                          <select class="form-control" id="input-select" name="role_id" >
						  @if($user->role_id)
			                   <option value="{{$user->role->id}}">{{$user->role->name}} </option>
						   @endif
			                 @foreach($roles as $role)
			                      <option value="{{$role->id}}">{{$role->name}}</option>
			                 @endforeach
                          </select>
                      </div>
			        
                  </div>
				   <div class="row">
                      <div class="form-group col-lg-6 col-md-6 col-sm-12">
                          <label for="" class="form-label" id="product-category">Employee</label>
                          <select class="form-control" id='selEmployee' name="employee_id" required >
			                    <option value="{{$user->employee->id}}">{{$user->employee->full_name_en}} </option>
			                 @foreach($employees as $employee)
			                      <option value="{{$employee->id}}">{{$employee->full_name_en}}</option>
			                 @endforeach
                          </select>
                      </div>
			        
                  </div>

              </div>
          </div>
		   <button type="submit" class="btn btn-primary btn-block" style="background-color: #376861 !important;">Update User</button>
<form>
</div>
@endsection
