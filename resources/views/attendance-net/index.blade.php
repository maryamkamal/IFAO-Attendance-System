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
<form method="GET" action="{{url('attendance-net/delete-selected')}}" class="form-div modal-content-div">
  {{ csrf_field() }}
  @method('DELETE')
<div class="table-outer-options-div">
    <div class="row">
	  @if(auth()->user()->authority('export','attendance_net_list')==1)
        <div class="btn-group col-lg-6 col-md-6 col-sm-12 excel-options-div" role="group" aria-label="Basic example">


            <a href="{{url('attendance-net/export')}}">
                <button type="button" class="btn btn-primary export-btn" style="background-color: #376861 !important;">
                    <i class="fas fa-file-export"></i>
                    <span>{{ __('attendance-net.export') }}</span>

                </button>
            </a>
        </div>
		@endif
     @if(auth()->user()->authority('modify','attendance_net_list')==1)
        <div class="col-lg-6 col-md-6 col-sm-12 add-product-div">
		{{--  <a href="{{url('attendance-net/update_all')}}">
                <button type="button" class="btn btn-primary export-btn" style="background-color: #376861 !important;">
                    <i class="fas fa-file-export"></i>
                    <span> {{ __('attendance-net.update_all_attendances') }}</span>

                </button>
		</a> --}}

             <button type="submit" class="btn btn-secondary delete-product-btn trash-btn" style="background-color: #d9ba71 !important;">
                <i class="fas fa-trash-alt"></i>
                <span> {{ __('attendance-net.delete_selected') }}</span>
            </button>

        </div>
		@endif
    </div>
</div>
<!---------------- users table  !------------------->
  <div class="system-table-div goods-table-div">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
              <h5 class="card-header table-header"> {{ __('attendance-net.attendance_net_list') }}</h5>
              <div class="card-body">
                  <div class="table-responsive">
				  <!----------------datatabled table  !------------------->
                      <table class="table table-striped table-bordered first data-table" id="attendance-net-table" style="overflow-x:auto;">
                          <thead>

                              <tr>
                                <th scope="col" class="img-title text-center check-all-parent">
                                    <input type="checkbox" id='attendance-net-checkall' />
                                </th>
								  <th scope="col" class="img-title text-center">{{ __('attendance-net.employee') }}</th>
                                  <th scope="col" class="img-title text-center"> {{ __('attendance-net.day') }}</th>
								  <th scope="col" class="img-title text-center"> {{ __('attendance-net.worked_duration') }}</th>
								  <th scope="col" class="img-title text-center">{{ __('attendance-net.overtime_hours') }}</th>
								  <th scope="col" class="img-title text-center">{{ __('attendance-net.overtime_percentage') }}</th>
								  <th scope="col" class="img-title text-center">{{ __('attendance-net.overtime_bonus') }}</th>
								  <th scope="col" class="img-title text-center">{{ __('attendance-net.delay_deduction') }}</th>
								  <th scope="col" class="img-title text-center"> {{ __('attendance-net.deducted_delay') }}</th>
								  <th scope="col" class="img-title text-center"> {{ __('attendance-net.delay') }} </th>
								  <th scope="col" class="options-title text-center"> {{ __('attendance-net.actions') }}</th>
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
