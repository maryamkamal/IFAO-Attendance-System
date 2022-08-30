@extends('layouts.home')
@section('content')

<!----------------success & error meessage  !------------------->
@if ($message = Session::get('success'))

<div class="alert alert-success alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
</div>

@endif

@if( Session::get('upload_error'))
@php($upload_errors = Session::get('upload_error'))
@foreach($upload_errors as $error)
<div class="alert alert-danger alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>

        <strong>{{$error}}</strong>
</div>
@endforeach
@endif

<!-- delete selected lables form   !-->
<form method="GET" action="{{url('attendance/delete-selected')}}" class="form-div modal-content-div">
  {{ csrf_field() }}
<div class="table-outer-options-div">
    <div class="row">
	 @if(auth()->user()->authority('export','attendance_list')==1)
        <div class="btn-group col-lg-6 col-md-6 col-sm-12 excel-options-div" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary import-btn" data-toggle="modal" data-target="#updating-import-modal" style="background-color: #d9ba71 !important;">
                    <i class="fas fa-file-import"></i>
                    <span>{{ __('attendance.updating_import') }}</span>
                </button>
                <button type="button" class="btn btn-secondary import-btn" data-toggle="modal" data-target="#inserting-import-modal" style="background-color: #d9ba71 !important;">
                    <i class="fas fa-file-import"></i>
                    <span>{{ __('attendance.inserting_import') }}</span>

                </button>

            <a href="{{url('attendance/export')}}">
                <button type="button" class="btn btn-primary export-btn" style="background-color: #376861 !important;">
                    <i class="fas fa-file-export"></i>
                    <span>{{ __('attendance.export') }}</span>

                </button>
            </a>
        </div>
		@endif
        @if(auth()->user()->authority('modify','attendance_list')==1)
        <div class="col-lg-6 col-md-6 col-sm-12 add-product-div">
            <a href="{{url('attendance/create')}}" type="button" class="btn btn-primary add-btn" style="background-color: #376861 !important;">
                <i class="fas fa-plus-circle"></i>
                <span>{{ __('attendance.add_employee_attendance') }}</span>
            </a>

             <button type="submit" class="btn btn-secondary delete-product-btn trash-btn" style="background-color: #d9ba71 !important;">
                <i class="fas fa-trash-alt"></i>
                <span>{{ __('attendance.delete_selected') }}</span>
            </button>

        </div>
		@endif
    </div>
</div>
<!---------------- users table  !------------------->
  <div class="system-table-div goods-table-div">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
               <h5 class="card-header table-header">{{ __('attendance.attendance_list') }}</h5>
              <div class="card-body">
                  <div class="table-responsive">
				  <!----------------datatabled table  !------------------->
                      <table class="table table-striped table-bordered first data-table" id="attendance-table" style="overflow-x:auto;">
                          <thead>

                              <tr>
                                <th>
                                    <input type="checkbox" id='attendance_checkall' />
                                </th>
								  <th scope="col" class="img-title text-center"> {{ __('attendance.employee') }}</th>
								   <th scope="col" class="img-title text-center">{{ __('attendance.work_schedule_profile') }}</th>
								   <th scope="col" class="img-title text-center"> {{ __('attendance.overtime_profile') }}</th>
                                  <th scope="col" class="img-title text-center"> {{ __('attendance.day') }}</th>
								  <th scope="col" class="img-title text-center"> {{ __('attendance.from') }}</th>
								  <th scope="col" class="img-title text-center">{{ __('attendance.to') }}</th>
								   <th scope="col" class="img-title text-center">Leave Type</th>
								  <th scope="col" class="options-title text-center">{{ __('attendance.actions') }}</th>
                              </tr>
                          </thead>

                      </table>
                  </div>
              </div>

          </div>
      </div>
  </div>
</form>
@endsection
<!----------------import section modal starts  !------------------->
@section('modal')

<div class="modal-section">
    <div class="modal fade" id="inserting-import-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" id="big-modal" role="document">
            <div class="modal-content">
                <div class="modal-attendance">
                    <h5 class="modal-title" id="modal-title">{{ __('attendance.import_export') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
				@if(count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

   @if($message = Session::get('success'))
   <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
           <strong>{{ $message }}</strong>
   </div>
   @endif
   @if( Session::get('upload_error'))
@php($upload_errors = Session::get('upload_error'))
@foreach($upload_errors as $error)
<div class="alert alert-danger alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>

        <strong>{{$error}}</strong>
</div>
@endforeach
@endif

   
                <div class="modal-body import-modal-body">
                    <div class="step-div first-step">
                        <div class="step-title">
                            <p class="step-number">
                                <i class="fas fa-hand-point-right"></i>
                                <span>{{ __('attendance.step_1') }}</span>
                            </p>
                            <span class="step-p">{{ __('attendance.Download your files, then insert data') }}</span>
                        </div>
                        <div class="step-content row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
							<a href="{{url('attendance/insert/export')}}">
                                <button class="import-new-product-btn btn btn-primary import-modal-btn" style="background-color: #376861 !important;">
                                    <i class="fas fa-file-import"></i>
                                    <span>{{ __('attendance.excel_file_to_insert_employee_attendance') }}</span>
                                </button>
								</a>
                            </div>
                        </div>
					
                    </div>
                    <div class="step-div second-step">
                        <div class="step-title">
                            <p class="step-number">
                                <i class="fas fa-hand-point-right"></i>
                                <span>{{ __('attendance.step_2') }}</span>
                            </p>
                            <span class="step-p">{{ __('attendance.Add the file that was uploaded in the previous step to Insert Employee Attendance') }}</span>
                        </div>
                        <div class="step-content">
                            <form method="post" enctype="multipart/form-data" action="{{url('attendance/insert/import')}}"class="upload-import-file-form">
							 {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="form-label">{{ __('attendance.upload_file') }}</label>
                                    <div class="form-img-div">
                                        <input type='file' name="attendance_insert_import" onchange="readURL(this);" />
                                    </div>
                                </div>

                        </div>
                    </div>
                <div class="modal-footer">
				    <button type="submit" class="btn btn-primary" style="background-color: #376861 !important;">{{ __('attendance.import') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"style="background-color: #d9ba71 !important;">{{ __('attendance.close') }}</button>
                </div>
				</form>
            </div>
        </div>
    </div>
</div>
<!--------------------------------------------------------------------------------------------------------------------------------------------------------------!-->
    <div class="modal fade" id="updating-import-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" id="big-modal" role="document">
            <div class="modal-content">
                <div class="modal-attendance">
                    <h5 class="modal-title" id="modal-title">{{ __('attendance.import_export') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
				@if(count($errors) > 0)
    <div class="alert alert-danger">
     Upload Validation Error<br><br>
     <ul>
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
     </ul>
    </div>
   @endif

   @if ($message = Session::get('success'))

<div class="alert alert-success alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
</div>

@endif
@if( Session::get('upload_error'))
@php($upload_errors = Session::get('upload_error'))
@foreach($upload_errors as $error)
<div class="alert alert-danger alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>

        <strong>{{$error}}</strong>
</div>
@endforeach
@endif
@php( Session::forget('upload_error'))

                <div class="modal-body import-modal-body">
                    <div class="step-div first-step">
                        <div class="step-title">
                            <p class="step-number">
                                <i class="fas fa-hand-point-right"></i>
                                <span>Step 1 :</span>
                            </p>
                            <span class="step-p">{{ __('attendance.Select Employee And Attendance Duration,Download your files, then Update data') }}</span>
                        </div>
						<form method="GET" enctype="multipart/form-data" action="{{url('attendance/update/export')}}">
							 {{ csrf_field() }}
                        <div class="step-content row">
						<div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.employee') }} </label>
                            <select  class="form-control"  name="employee_id"  required>
							<option value="all_employees">{{ __('attendance.all_employees') }}</option>
							@foreach($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->full_name_en}}</option>
								@endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.from') }}</label>
                            <input type="date" class="form-control" name="from" required>
                        </div>
						 <div class="form-group col-lg-4 col-md-6 col-sm-12">
                            <label class="form-label">{{ __('attendance.to') }}</label>
                            <input type="date" class="form-control" name="to" required>
                        </div>
						</div>
						 <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <button class="import-new-product-btn btn btn-primary import-modal-btn"type="submit" style="background-color: #376861 !important;">
                                    <i class="fas fa-file-import"></i>
                                    <span>{{ __('attendance.excel_file_to_update_employee_attendance') }}</span>
                                </button>
								</a>
                            </div>
                        </div>
						</form>
					
                    </div>
                    <div class="step-div second-step">
                        <div class="step-title">
                            <p class="step-number">
                                <i class="fas fa-hand-point-right"></i>
                                <span>{{ __('attendance.step_2') }}</span>
                            </p>
                            <span class="step-p">{{ __('attendance.Add the file that was uploaded in the previous step to Update  Employee Attendance') }}</span>
                        </div>
                        <div class="step-content">
                            <form method="POST" enctype="multipart/form-data" action="{{url('attendance/update_import')}}"class="upload-import-file-form">
							 {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="form-label">{{ __('attendance.upload_file') }}</label>
                                    <div class="form-img-div">
                                        <input type='file' name="attendance_update_import" onchange="readURL(this);" />
                                    </div>
                                </div>
                        </div>
                    </div>
                <div class="modal-footer">
				    <button type="submit" class="btn btn-primary" style="background-color: #376861 !important;">{{ __('attendance.import') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"style="background-color: #d9ba71 !important;">{{ __('attendance.close') }}</button>
                </div>
				</form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
