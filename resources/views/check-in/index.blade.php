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


 <div class="add-new-product-div">

  <div class="row">

        <div class="btn-group col-lg-6 col-md-6 col-sm-12 excel-options-div">
		        <a href="{{url('check-in/search')}}">
                <button type="button" class="btn btn-secondary import-btn" data-toggle="modal" data-target="#import-modal" style="background-color: #376861 !important;width:200px;margin-left:200px" >
                    <i class="fas fa-file-import"></i>
                    <span>{{ __('check-in-out.check_in') }}</span>

                </button>
				</a>
             </div>

			  <div class="btn-group col-lg-6 col-md-6 col-sm-12 excel-options-div">
            <a href="{{url('check-out/search')}}">
                <button type="button" class="btn btn-primary export-btn"style="background-color: #d9ba71 !important;width:200px;margin-left:200px" >
                    <i class="fas fa-file-export"></i>
                    <span>{{ __('check-in-out.check_out') }}</span>

                </button>
            </a>
        </div>
    </div>

    </div>

@endsection
