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
<!-- delete selected lables form   !-->
<form method="GET" action="{{url('employee/leaves/delete-selected')}}" class="form-div modal-content-div">
  {{ csrf_field() }}
  @method('DELETE')
   <div class="table-outer-options-div">
    <div class="row">
	@if(auth()->user()->authority('export','assign_employee_leave')==1)
        <div class="btn-group col-lg-6 col-md-6 col-sm-12 excel-options-div" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary import-btn" data-toggle="modal" data-target="#import-modal" style="background-color: #d9ba71 !important;">
                    <i class="fas fa-file-import"></i>
                    <span>{{__('employee-leaves.import')}}</span>

                </button>
            
            <a href="{{url('employee/leaves/export')}}">
                <button type="button" class="btn btn-primary export-btn" style="background-color: #376861 !important;">
                    <i class="fas fa-file-export"></i>
                    <span>{{__('employee-leaves.export')}}</span>
                </button>
            </a>
			<button type="submit" class="btn btn-secondary delete-product-btn trash-btn" style="background-color: #d9ba71 !important;">
                <i class="fas fa-trash-alt"></i>
                <span>Delete Selected</span>
            </button>
        </div>
		@endif
		@if(auth()->user()->authority('modify','assign_employee_leave')==1)
		<div class="col-lg-6 col-md-6 col-sm-12 add-product-div">
		{{--  <a href="{{url('employee/leaves/updateLeaveAbsence')}}">
                <button type="button" class="btn btn-primary export-btn" style="background-color: #376861 !important;">
                    <i class="fas fa-file-export"></i>
                    <span>{{__('employee-leaves.Add Leaves To Absence')}} </span>

                </button>
		</a> --}}
            <a href="{{url('employee/leaves/create')}}" type="button" class="btn btn-primary add-btn" style="background-color: #376861 !important;">
                <i class="fas fa-plus-circle"></i>
                <span>{{__('employee-leaves.add_employee_leave')}}  </span>
            </a>
        </div>
		@endif
    </div>
</div>
     <div class="system-table-div goods-table-div">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
              <h5 class="card-header table-header">{{__('employee-leaves.Employees Leaves')}} </h5>
              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered first data-table" id="employees-leaves-table">
                          <thead>

                              <tr>
                                 <th>
                                    <input type="checkbox" id='employees-leaves-table-checkall' />
                                </th>
                                  <th scope="col" class="category-title text-center"> {{__('employee-leaves.Employee')}}</th>
								  <th scope="col" class="category-title text-center"> {{__('employee-leaves.Leave')}}</th>
								  <th scope="col" class="category-title text-center"> {{__('employee-leaves.from')}} </th>
                                  <th scope="col" class="category-title text-center">{{__('employee-leaves.to')}} </th>
                                  <th scope="col" class="category-title text-center">{{__('employee-leaves.status')}}  </th>
								  <th scope="col" class="options-title text-center">{{__('employee-leaves.actions')}} </th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
  </form>
@endsection
@section('modal')

<div class="modal-section">
    <div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" id="big-modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">{{__('employee-leaves.Import / Export Employee Leaves')}} </h5>
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
                <div class="modal-body import-modal-body">
                    <div class="step-div first-step">
                        <div class="step-title">
                            <p class="step-number">
                                <i class="fas fa-hand-point-right"></i>
                                <span>{{__('employee-leaves.Step 1 :')}} </span>
                            </p>
                            <span class="step-p"> {{__('employee-leaves.Download your files, then insert data...')}} </span>
                        </div>
                        <div class="step-content row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
							<a href="{{url('employee/leaves/export_insert')}}">
                                <button class="import-new-product-btn btn btn-primary import-modal-btn" style="background-color: #376861 !important;">
                                    <i class="fas fa-file-import"></i>
                                    <span>{{__('employee-leaves.')}} </span>
                                </button>
								</a>
                            </div>
                        </div>
                    </div>
                    <div class="step-div second-step">
                        <div class="step-title">
                            <p class="step-number">
                                <i class="fas fa-hand-point-right"></i>
                                <span> {{__('employee-leaves.Step 2 :')}} </span>
                            </p>
                            <span class="step-p">{{__('employee-leaves.Add the file that was uploaded in the previous step to insert Employee Leaves.')}} </span>
                        </div>
                        <div class="step-content">
                            <form method="post" enctype="multipart/form-data" action="{{url('employee/leaves/import')}}"class="upload-import-file-form">
							 {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="form-label">{{__('employee-leaves.Upload File')}} </label>
                                    <div class="form-img-div">
                                        <input type='file' name="employee_leave_import" onchange="readURL(this);" />
                                        <img src="http://placehold.it/180" alt="your image" id="form-product-img"/>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
				    <button type="submit" class="btn btn-primary" style="background-color: #376861 !important;">{{__('employee-leaves.import')}} </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"style="background-color: #d9ba71 !important;">{{__('employee-leaves.Close')}} </button>
                </div>
				</form>
            </div>
        </div>
    </div>
</div>
@endsection

