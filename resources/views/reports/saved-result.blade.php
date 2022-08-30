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

    <div class="container-fluid">
                @if($selected_columns != null)
                <div class="card card-body basic-info-content" id="report_result" >
                
					<div class="table-outer-options-div">
                    <div class="row">
                            <div class="btn-group col-lg-6 col-md-6 col-sm-12 excel-options-div" role="group" aria-label="Basic example">
		
		                         <a href="reports/export">
                                    <button type="button" class="btn btn-primary export-btn" style="background-color: #376861 !important;">
                                        <i class="fas fa-file-export"></i>
                                        <span>Export</span>
                                    </button>
                                </a>
			
                                <a href="reports/print">
                                    <button type="button" class="btn btn-secondary print-btn" style="background-color: #d9ba71 !important;">
                                        <i class="fas fa-print"></i>
                                        <span>Print</span>
                                    </button>
                                </a>
            
                             </div>

                <div class="col-lg-6 col-md-6 col-sm-12 add-product-div">
				                    <a href="reports/saved/delete/{{$report->id}}">
                                    <button type="button" class="btn btn-secondary trash-btn" style="background-color: #d9ba71 !important;">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Delete Report</span>
                                    </button>
									</a>
                                
        </div>
    </div>
</div>
                    <div class="system-table-div goods-table-div" >
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"id="report_data">
                            <div class="card">
                                <h5 class="card-header table-header">{{$tableModel}}</h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered first data-table" >
                                            <thead id ="table_heading">
                                            <tr>
                                                @foreach ($selected_columns as $column )

                                                 <th scope="col" class="img-title text-center">{{$column}}</th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody id ="table_body">
											 @foreach ($query_results as $query_result )
											 @php($query_result = json_decode(json_encode($query_result), true))
											<tr>
											 @foreach ($selected_columns as $column )
											 @if($column == 'employee_id' ||$column =='approved_by')
												 @php($result = App\Employee::find($query_result[$column]))
											 <td>{{$result['full_name_en']}}</td>
										    @elseif($column == 'permission_id')
											@php($result = App\Permission::find($query_result[$column]))
											 <td>{{$result['type']}}</td>
											 @elseif($column == 'leave_id')
											  @php($result = App\leave::find($query_result[$column]))
											 <td>{{$result['type']}}</td>
											 @elseif($column == 'work_schedule_id')
											  @php($result = App\WorkScheduleProfile::find($query_result[$column]))
											 <td>{{$result['name']}}</td>
											 @elseif($column == 'overtime_profile_id')
											  @php($result = App\OvertimeProfile::find($query_result[$column]))
											 <td>{{$result['name']}}</td>
											  
										   @else
											<td>{{$query_result[$column]}}</td>
											 @endif
											@endforeach
											</tr>
											@endforeach
                                            </tbody >
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                   @endif
            </div>

@endsection
