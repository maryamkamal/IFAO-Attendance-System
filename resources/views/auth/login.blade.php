@extends('layouts.login')

@section('content')

  <div class="login-page section">
      <div class="navbar">
          
      </div>
      <div class="login-page-content page-content">
         <div class="container">
              <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="img-side-div wow slideInLeft" data-wow-duration="2s" data-wow-delay=".1s">
                          <img src="{{url('img/login-img.png')}}" alt="login-img" id="login-img">
                          <p class="welcome-p black-font">Login Page </p>
                          <div class="welcome-desc">
                              <p class="gray-font">
                                  IFAO HR department system.
                              </p>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="login-form-div wow slideInRight" data-wow-duration="2s" data-wow-delay=".2s">
                          <div class="form-header">
                              <h4 class="black-font">login</h4>
                              <p class="gray-font">Please Enter User Name & Password </p>
                          </div>
                          <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                              <div class="form-group username-div input-div">
                                  <span> <i class="fas fa-user input-icon"></i></span>
                                  <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" name="name"  style ="width:200%; height:200%" value="{{ old('name') }}" required autofocus>
								  @error('name')
                                   <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                      </span>
                                     @enderror
                              </div>
                              <div class="form-group password-div input-div">
                                  <span> <i class="fas fa-lock input-icon"></i></span>
                                  <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} form-input" id="password-input" style ="width:200%; height:200%" name="password" required>

                                  @error('password')
                                  <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>

                              <div class="form-group submit-div">
                                  <button type="submit" class="login-btn" style ="width:200%; height:200%">Login </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
         </div>
      </div>
  </div>

 @endsection



