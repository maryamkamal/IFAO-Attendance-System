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

<!-- delete selected button form   !-->
<form method="GET" action="{{url('absence/delete-selected')}}" class="form-div modal-content-div">
  {{ csrf_field() }}
  @method('DELETE')
<div class="table-outer-options-div">
    <div class="row">
	 @if(auth()->user()->authority('export','absence_list')==1)
        <div class="btn-group col-lg-6 col-md-6 col-sm-12 excel-options-div" role="group" aria-label="Basic example">

                <button type="button" class="btn btn-secondary import-btn" data-toggle="modal" data-target="#import-modal" style="background-color: #d9ba71 !important;">
                    <i class="fas fa-file-import"></i>
                    <span>Import</span>

                </button>

            <a href="{{url('absence/export')}}">
                <button type="button" class="btn btn-primary export-btn" style="background-color: #376861 !important;">
                    <i class="fas fa-file-export"></i>
                    <span>Export</span>

                </button>
            </a>
        </div>
		@endif
       @if(auth()->user()->authority('modify','absence_list')==1)
        <div class="col-lg-6 col-md-6 col-sm-12 add-product-div">
            <a href="{{url('absence/create')}}" type="button" class="btn btn-primary add-btn" style="background-color: #376861 !important;">
                <i class="fas fa-plus-circle"></i>
                <span>Add Employee Absence</span>
            </a>

             <button type="submit" class="btn btn-secondary delete-product-btn trash-btn" style="background-color: #d9ba71 !important;">
                <i class="fas fa-trash-alt"></i>
                <span>Delete Selected</span>
            </button>

        </div>
		@endif
    </div>
</div>
<!---------------- users table  !------------------->
  <div class="system-table-div goods-table-div">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
              <h5 class="card-header table-header">Absence List</h5>
              <div class="card-body">
                  <div class="table-responsive">
				  <!----------------datatabled table  !------------------->
                      <table class="table table-striped table-bordered first data-table" id="absence-table">
                          <thead>

                              <tr>
                                <th>
                                    <input type="checkbox" id='absence_checkall' />
                                </th>
								  <th scope="col" class="img-title text-center"> Employee</th>
                                  <th scope="col" class="img-title text-center"> Day</th>
								  <th scope="col" class="img-title text-center"> Leave</th>
								  <th scope="col" class="img-title text-center"> Leave Status</th>
								  <th scope="col" class="options-title text-center">Actions</th>
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
    <div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" id="big-modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Import / Export</h5>
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
                                <span>Step 1 :</span>
                            </p>
                            <span class="step-p">Download your files, then insert data...</span>
                        </div>
                        <div class="step-content row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
							<a href="{{url('absence/export_insert')}}">
                                <button class="import-new-product-btn btn btn-primary import-modal-btn" style="background-color: #376861 !important;">
                                    <i class="fas fa-file-import"></i>
                                    <span>Excel File To Insert Employee Absence</span>
                                </button>
								</a>
                            </div>
                        </div>
                    </div>
                    <div class="step-div second-step">
                        <div class="step-title">
                            <p class="step-number">
                                <i class="fas fa-hand-point-right"></i>
                                <span>Step 2 :</span>
                            </p>
                            <span class="step-p">Add the file that was uploaded in the previous step to insert Employee Absence.</span>
                        </div>
                        <div class="step-content">
                            <form method="post" enctype="multipart/form-data" action="{{url('absence/import')}}"class="upload-import-file-form">
							 {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="form-label">Upload File</label>
                                    <div class="form-img-div">
                                        <input type='file' name="absence_import" onchange="readURL(this);" />
                                        <img src="http://placehold.it/180" alt="your image" id="form-product-img"/>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
				    <button type="submit" class="btn btn-primary" style="background-color: #376861 !important;">import</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"style="background-color: #d9ba71 !important;">Close</button>
                </div>
				</form>
            </div>
        </div>
    </div>
</div>
@endsection
